<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\RequestQuotation;
use Acted\LegalDocsBundle\Entity\PaymentTermRequestQuotation;
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

                /*Create new request with draft status*/
                $newRequestQuotation = new RequestQuotation();
                $newRequestQuotation->setEvent($event);
                $newRequestQuotation->setStatus(RequestQuotation::STATUS_DRAFT);
                $em->persist($newRequestQuotation);
                $em->flush();

            }

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

//            \Doctrine\Common\Util\Debug::dump($newRequestQuotation);
//            $connection->rollback();

            $paymentTerms = array();
            if (!empty($newRequestQuotation->getPaymentTermRequestQuotation())) {
                $paymentTerms = array(
                    'balance_percent' => $newRequestQuotation->getPaymentTermRequestQuotation()->getBalancePercent()
                );
            }

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
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

            $requestQuotationRepo->setOutdatedStatus($event);
            $requestQuotationRepo->setPublishedStatus($requestQuotation->getId());

            $paymentTermRequestQuotation = new PaymentTermRequestQuotation();
            $paymentTermRequestQuotation->setBalancePercent($balancePercent);
            $paymentTermRequestQuotation->setGuaranteedDepositPercent(PaymentTermRequestQuotation::GUARANTEED_DEPOSIT_PERCENT);
            $em->persist($paymentTermRequestQuotation);

            $em->flush();

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
        }
        //generate pdf file
        //send mail

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
        $performanceRequestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:PerformanceRequestQuotation');
        $resultUpdating = $performanceRequestQuotationRepo->changePerformanceSelected($requestId, $performanceId);

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
        $serviceRequestQuotationRepo = $em->getRepository('ActedLegalDocsBundle:ServiceRequestQuotation');
        $resultUpdating = $serviceRequestQuotationRepo->changeServiceSelected($requestId, $serviceId);

        return new JsonResponse(['status' => 'success']);
    }
}
