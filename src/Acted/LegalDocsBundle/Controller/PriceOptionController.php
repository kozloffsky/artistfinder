<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Option;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Form\PriceOptionCreateType;
use Acted\LegalDocsBundle\Form\PriceOptionEditType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;


class PriceOptionController extends Controller
{
    public function createAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $priceOptionCreateForm = $this->createForm(PriceOptionCreateType::class, null, ['method' => 'POST']);
        $priceOptionCreateForm->handleRequest($request);

        if ($priceOptionCreateForm->isSubmitted() && (!$priceOptionCreateForm->isValid())) {
            return new JsonResponse($serializer->toArray($priceOptionCreateForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $data = $priceOptionCreateForm->getData();
        if (empty($data)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'There are not any data'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $package = $data['package'];
        $duration = $data['duration'];
        $qty = $data['qty'];
        $priceOnRequest = $data['price_on_request'];

        $option = new Option();
        $option->setPackage($package);
        $option->setDuration($duration);
        $option->setQty($qty);
        $option->setPriceOnRequest($priceOnRequest);
        $em->persist($option);

        $em->flush();

        return new JsonResponse(array('status' => 'success', 'id' => $option->getId()));
    }

    public function editAction(Request $request, Option $option)
    {
        $serializer = $this->get('jms_serializer');

        $priceOptionEditForm = $this->createForm(PriceOptionEditType::class, null, ['method' => 'PATCH']);
        $priceOptionEditForm->handleRequest($request);

        if ($priceOptionEditForm->isSubmitted() && (!$priceOptionEditForm->isValid())) {
            return new JsonResponse($serializer->toArray($priceOptionEditForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $data = $priceOptionEditForm->getData();

        if (empty($data)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'There are not any data'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $duration = null;
        $qty = null;

        $duration = empty($data['duration']) ? null : $data['duration'];
        $qty = empty($data['qty']) ? null : $data['qty'];

        /*Check if standard or base performance then qty and duration required*/
        $package = $option->getPackage();
        if (!empty($package->getPerformance())) {
            $type = $package->getPerformance()->getType();

            if (($type == Performance::TYPE_BASE || $type == Performance::TYPE_STANDARD) &&
                empty($qty) || empty($duration)
            ) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'duration or qty is empty'
                ],  Response::HTTP_BAD_REQUEST);
            }
        }

        $priceOnRequest = $data['price_on_request'];

        $option->setDuration($duration);
        $option->setQty($qty);
        $option->setPriceOnRequest($priceOnRequest);
        $em->persist($option);

        $em->flush();
        return new JsonResponse(array('status' => 'success'));
    }

    public function removeAction(Request $request, Option $option)
    {
        $serializer = $this->get('jms_serializer');

        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->beginTransaction();

        try {
            $optionRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Option');

            $rateRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Rate');

            $rateIds = $rateRepository->getRateIdsByOptionIds($option->getId());

            $optionRepository->removeOptions($option->getId());
            $rateRepository->removeRates($rateIds);
            $em->flush();

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Removing error'
            ],  Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(array('status' => 'success'));
    }

    /**
     * Change selecting option
     *
     * @ApiDoc(
     *  resource=true,
     *  description="change selecting option",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param integer $id
     * @return JsonResponse
     */
    public function selectAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        try {
            $packageRepo = $em->getRepository('ActedLegalDocsBundle:Package');
            $optionRepo = $em->getRepository('ActedLegalDocsBundle:Option');
            $resultUpdating = $optionRepo->changeOptionSelected($id);

            $option = $optionRepo->find($id);
            if (empty($option)) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Option does not exist'
                ],  Response::HTTP_BAD_REQUEST);
            }

            $isSelected = $option->getIsSelected();

            $package = $option->getPackage();

            $isSelectedAnyOption = $optionRepo->checkIsSelectedOptionsInPackage($package->getId());
            if ((!$isSelectedAnyOption && !$isSelected) || $isSelected) {
                $package->setIsSelected($isSelected);
                $em->persist($package);
                $em->flush();
            }

            $service = $package->getService();
            $performance = $package->getPerformance();

            if (!empty($service)) {
                $serviceRequestQuotations = $service->getServiceRequestQuotations();
                $serviceRequestQuotation = $serviceRequestQuotations[0];

                if (empty($serviceRequestQuotation)) {
                    $em->getConnection()->rollback();

                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Service request quotation does not exist'
                    ],  Response::HTTP_BAD_REQUEST);
                }

                $serviceRequestQuotation->setIsSelected($isSelected);
                $em->persist($serviceRequestQuotation);
            }

            if (!empty($performance)) {
                $performanceRequestQuotations = $performance->getPerformanceRequestQuotations();
                $performanceRequestQuotation = $performanceRequestQuotations[0];

                if (empty($performanceRequestQuotation)) {
                    $em->getConnection()->rollback();

                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Performance request quotation does not exist'
                    ],  Response::HTTP_BAD_REQUEST);
                }

                $isSelectedAnyPackage = $packageRepo->checkIsSelectedPackagesInPerformance($performance->getId());
                if ((!$isSelectedAnyPackage && !$isSelected) || $isSelected) {
                    $performanceRequestQuotation->setIsSelected($isSelected);
                    $em->persist($performanceRequestQuotation);
                }
            }

            $em->flush();
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Error changing selecting of package'
            ],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new JsonResponse(['status' => 'success']);
    }
}
