<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\RequestQuotation;
use Acted\LegalDocsBundle\Entity\PaymentTermRequestQuotation;
use Acted\LegalDocsBundle\Entity\DocumentRequestQuotation;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Entity\Package;
use Acted\LegalDocsBundle\Entity\Price;
use Acted\LegalDocsBundle\Entity\Option;
use Acted\LegalDocsBundle\Entity\Rate;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Acted\LegalDocsBundle\Form\RequestQuotationPrepareType;
use Acted\LegalDocsBundle\Form\RequestQuotationSendType;

class RequestQuotationController extends Controller
{
    /**
     * Prepare quotations
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Prepare quotations",
     *  input="Acted\LegalDocsBundle\Form\RequestQuotationPrepareType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function prepareAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $requestQuotationPrepareForm = $this->createForm(RequestQuotationPrepareType::class, null, ['method' => 'POST']);
        $requestQuotationPrepareForm->handleRequest($request);

        if ($requestQuotationPrepareForm->isSubmitted() && (!$requestQuotationPrepareForm->isValid())) {
            return new JsonResponse($serializer->toArray($requestQuotationPrepareForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ActedLegalDocsBundle:User')->find(351);

        //$user = $this->getUser();

        if (empty($user)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'User is not authorized'
            ],  Response::HTTP_UNAUTHORIZED);
        }

        $requestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:RequestQuotation');
        $performanceRepo = $em->getRepository('ActedLegalDocsBundle:Performance');
        $serviceRepo = $em->getRepository('ActedLegalDocsBundle:Service');
        $performanceRequestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:PerformanceRequestQuotation');
        $serviceRequestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:ServiceRequestQuotation');
        $eventRepo = $em->getRepository('ActedLegalDocsBundle:Event');

        $isExistsDraftedRequestQuotation = false;
        $isExistsPublishedRequestQuotation = false;

        $draftedRequestQuotationId = null;
        $publishedRequestQuotationId = null;

        $profile = $user->getProfile();

        $connection = $em->getConnection();
        $connection->beginTransaction();

        $data = $requestQuotationPrepareForm->getData();
        $event = $data['event'];

        $eventOfferRepo = $em->getRepository('ActedLegalDocsBundle:EventOffer');
        $preSelectedPerformanceIds = $eventOfferRepo->getPerformanceIds($event);

        $requestQuotations = $requestQuotationRepo->findBy(array('event' => $event));

        foreach ($requestQuotations as $requestQuotation) {
            if ($requestQuotation->getStatus() == RequestQuotation::STATUS_DRAFT) {
                $isExistsDraftedRequestQuotation = true;
                $draftedRequestQuotationId = $requestQuotation->getId();
                $draftedRequestQuotationObj = $requestQuotation;
            } else {
                $isExistsPublishedRequestQuotation = true;
                $publishedRequestQuotationId = $requestQuotation->getId();
                $publishedRequestQuotationObj = $requestQuotation;
            }
        }


        try {
            //if request is draft

            if ($isExistsDraftedRequestQuotation) {

                $draftServiceRequestQuotations = $performanceRequestQuotationRepo->getDraftPerformanceRequestQuotations($draftedRequestQuotationId);
                $draftPerformanceRequestQuotations = $serviceRequestQuotationRepo->getDraftServiceRequestQuotations($draftedRequestQuotationId);

                $draftServiceRequestQuotationRelatedListIds = $serviceRequestQuotationRepo->getRelatedServiceIds($draftServiceRequestQuotations);
                $draftPerformanceRequestQuotationRelatedListIds = $performanceRequestQuotationRepo->getRelatedPerformanceIds($draftPerformanceRequestQuotations);

                $isRemoved = $requestQuotationRepo->removeDraftedRequestQuotation(
                    $draftPerformanceRequestQuotationRelatedListIds,
                    $draftServiceRequestQuotationRelatedListIds,
                    $draftedRequestQuotationId,
                    $connection
                );
            }

            /*Create new request with draft status*/
            $newRequestQuotation = $requestQuotationRepo->createDraftRequestQuotation($event);

            if ($isExistsPublishedRequestQuotation) {
                //copy performances from published requestQuotation
                $performanceRequestQuotations = $performanceRequestQuotationRepo->getPerformanceRequestQuotations($publishedRequestQuotationId);
                $performanceRequests = $performanceRequestQuotationRepo->copyPerformanceRequestQuotation($performanceRequestQuotations, $profile, $newRequestQuotation, $preSelectedPerformanceIds);

                //copy services from published requestQuotation
                $serviceRequestQuotations = $serviceRequestQuotationRepo->getServiceRequestQuotations($publishedRequestQuotationId);
                $serviceRequests = $serviceRequestQuotationRepo->copyServiceRequestQuotation($serviceRequestQuotations, $profile, $newRequestQuotation);

                /*copy payment terms*/
                $newPaymentTermRequestQuotation = new PaymentTermRequestQuotation();

                $newPaymentTermRequestQuotation->setGuaranteedDepositPercent(
                    $publishedRequestQuotationObj->getPaymentTermRequestQuotation()->getGuaranteedDepositPercent()
                );

                $newPaymentTermRequestQuotation->setBalancePercent(
                    $publishedRequestQuotationObj->getPaymentTermRequestQuotation()->getBalancePercent()
                );

                $newPaymentTermRequestQuotation->setRequestQuotation($newRequestQuotation);
                $em->persist($newPaymentTermRequestQuotation);
                $em->flush();

                $newRequestQuotation->setPaymentTermRequestQuotation($newPaymentTermRequestQuotation);
            } else {
                //copy performances from base data(performance)
                $performanceRequestQuotations = $performanceRepo->getPerformancesByProfileId($profile->getId());
                $performanceRequests = $performanceRequestQuotationRepo->copyPerformanceRequestQuotation($performanceRequestQuotations, $profile, $newRequestQuotation, $preSelectedPerformanceIds);

                //copy services from base data(service)
                $serviceRequestQuotations = $serviceRepo->getServicesByProfileId($profile->getId());
                $serviceRequests = $serviceRequestQuotationRepo->copyServiceRequestQuotation($serviceRequestQuotations, $profile, $newRequestQuotation);
            }

            $paymentTerms = array();
            if (!empty($newRequestQuotation->getPaymentTermRequestQuotation())) {
                $paymentTerms = array(
                    'balance_percent' => $newRequestQuotation->getPaymentTermRequestQuotation()->getBalancePercent()
                );
            }

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();

            return new JsonResponse([
                'status' => 'error',
                'message' => 'Preparing error'
            ],  Response::HTTP_BAD_REQUEST);
            //\Doctrine\Common\Util\Debug::dump($e->getMessage());exit;
        }

        $serviceRequestQuotations = $serviceRequestQuotationRepo->getServiceRequestQuotations($newRequestQuotation->getId());
        $performanceRequestQuotations = $performanceRequestQuotationRepo->getPerformanceRequestQuotations($newRequestQuotation->getId());

        return new JsonResponse([
            'status' => 'success',
            'services' => $serviceRequestQuotations,
            'performances' => $performanceRequestQuotations,
            'request_quotation' => array(
                'id' => $newRequestQuotation->getId(),
                'status' => $newRequestQuotation->getStatus(),
                'isOutdated' => $newRequestQuotation->getIsOutdated()
            ),
            'payment_terms' => $paymentTerms
        ]);
    }


    /**
     * Send quotations
     *
     * @ApiDoc(
     *  resource=true,
     *  description="send quotations",
     *  input="Acted\LegalDocsBundle\Form\RequestQuotationSendType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function sendAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $requestQuotationPrepareForm = $this->createForm(RequestQuotationSendType::class, null, ['method' => 'POST']);
        $requestQuotationPrepareForm->handleRequest($request);

        if ($requestQuotationPrepareForm->isSubmitted() && (!$requestQuotationPrepareForm->isValid())) {
            return new JsonResponse($serializer->toArray($requestQuotationPrepareForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $data = $requestQuotationPrepareForm->getData();
        $event = $data['event'];
        $requestQuotation = $data['request_quotation'];
        $balancePercent = $data['balance_percent'];

        $connection = $em->getConnection();
        $connection->beginTransaction();

          try {
              $requestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:RequestQuotation');

              $requestQuotationRepo->setOutdatedStatus($event->getId());
              $requestQuotationRepo->setPublishedStatus($requestQuotation->getId());

              $paymentTermRequestQuotation = new PaymentTermRequestQuotation();
              $paymentTermRequestQuotation->setBalancePercent($balancePercent);
              $paymentTermRequestQuotation->setGuaranteedDepositPercent(PaymentTermRequestQuotation::GUARANTEED_DEPOSIT_PERCENT);
              $em->persist($paymentTermRequestQuotation);

              $performanceRequestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:PerformanceRequestQuotation');
              $serviceRequestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:ServiceRequestQuotation');

              $serviceRequestQuotations = $serviceRequestQuotationRepo->getServiceRequestQuotations($requestQuotation->getId());
              $performanceRequestQuotations = $performanceRequestQuotationRepo->getPerformanceRequestQuotations($requestQuotation->getId());

              $services = [];
              $performances = [];

              foreach ($serviceRequestQuotations as $serviceRequestQuotation) {
                  $services[] = $serviceRequestQuotation['service'];
              }

              foreach ($performanceRequestQuotations as $performanceRequestQuotation) {
                  $performances[] = $performanceRequestQuotation['performance'];
              }

              //\Doctrine\Common\Util\Debug::dump($event);exit;

              /*Generate pdf file*/
              //todo: we need to decide which id get from chatRoom in the future
              $chatRoomId = $event->getChatRooms()->first()->getId();

              $path = $this->get('request_quotation_type')
                  ->setData(array(
                      'services' => $services,
                      'performances' => $performances,
                      'event' => array(
                          'title' => $event->getTitle(),
                          'location' => $event->getAddress(),
                          'startingDate' => $event->getStartingDate(),
                          "endingDate" => $event->getEndingDate(),
                          "timing" => $event->getTiming(),
                          "numberOfGuests" => $event->getNumberOfGuests(),
                          "city" => $event->getCity(),
                          "clientFirstname" => $event->getUser()->getFirstname(),
                          "clientLastname" => $event->getUser()->getLastname(),
                          "venueType" => $event->getVenueType()->getVenueType()
                      ),

                      'payment_term' => array(
                          'balance_percent' => $balancePercent
                      )
                  ))
                  ->getParsedTemplate()
                  ->generateDocumentPdf($chatRoomId, $requestQuotation->getId());


              $documentRequestQuotation = new DocumentRequestQuotation();
              $documentRequestQuotation->setRequestQuotation($requestQuotation);
              $documentRequestQuotation->setPath($path);
              $em->persist($documentRequestQuotation);

              //send mail

              $em->flush();

              $connection->commit();
          } catch (\Exception $e) {
              $connection->rollback();

              return new JsonResponse([
                  'status' => 'error',
                  'message' => 'Sending error'
              ],  Response::HTTP_BAD_REQUEST);
          }

        return new JsonResponse(['status' => 'success']);
    }

    /**
     * Change selecting performance
     *
     * @ApiDoc(
     *  resource=true,
     *  description="change selecting performance",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param integer $requestId
     * @param integer $performanceId
     * @return JsonResponse
     */
    public function selectPerformanceAction(Request $request, $requestId, $performanceId)
    {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();
        $connection->beginTransaction();

        try {

            $performanceRequestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:PerformanceRequestQuotation');
            $resultUpdating = $performanceRequestQuotationRepo->changePerformanceSelected($requestId, $performanceId);

            $performanceRepo = $em->getRepository('ActedLegalDocsBundle:Performance');
            //$performance = $performanceRepo->findOneBy(array('id' => $performanceId, 'deletedTime' => null));

            $performance = $performanceRepo->getFullPerformanceById($performanceId);
            $performance = $performance[0];

            $performanceRQ = $performanceRequestQuotationRepo->findOneBy(array('requestQuotation' => $requestId, 'performance' => $performanceId));

            if (empty($performanceRQ)) {
              return new JsonResponse([
                  'status' => 'error',
                  'message' => 'current performance is not exists'
              ],  Response::HTTP_BAD_REQUEST);    
            }

            $requestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:RequestQuotation');
            $requestQuotationRepo->selectObjectsOfPerformanceService($performance, $performanceRQ->getIsSelected());

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();

            return new JsonResponse([
                'status' => 'error',
                'message' => 'Sending error'
            ],  Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'success']);
    }


    /**
     * Change selecting service
     *
     * @ApiDoc(
     *  resource=true,
     *  description="change selecting performance",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param integer $requestId
     * @param integer $serviceId
     * @return JsonResponse
     */
    public function selectServiceAction(Request $request, $requestId, $serviceId)
    {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();
        $connection->beginTransaction();

        try {
            $serviceRequestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:ServiceRequestQuotation');
            $resultUpdating = $serviceRequestQuotationRepo->changeServiceSelected($requestId, $serviceId);

            $serviceRepo = $em->getRepository('ActedLegalDocsBundle:Service');
            //$service = $serviceRepo->findOneBy(array('id' => $serviceId, 'deletedTime' => null));

            $service = $serviceRepo->getFullServiceById($serviceId);
            $service = $service[0];

            $serviceRequestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:ServiceRequestQuotation');
            $serviceRQ = $serviceRequestQuotationRepo->findOneBy(array('requestQuotation' => $requestId, 'service' => $serviceId));

            if (empty($serviceRQ)) {
              return new JsonResponse([
                  'status' => 'error',
                  'message' => 'current service is not exists'
              ],  Response::HTTP_BAD_REQUEST);    
            }

            $requestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:RequestQuotation');
            $requestQuotationRepo->selectObjectsOfPerformanceService($service, $serviceRQ->getIsSelected());

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Sending error'
            ],  Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['status' => 'success']);
    }
}
