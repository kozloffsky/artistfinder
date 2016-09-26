<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Option;
use Acted\LegalDocsBundle\Form\PriceOptionCreateType;
use Acted\LegalDocsBundle\Form\PriceOptionEditType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


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

        $option = new Option();
        $option->setPackage($package);
        $option->setDuration($duration);
        $option->setQty($qty);
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
        $duration = $data['duration'];
        $qty = $data['qty'];

        $option->setDuration($duration);
        $option->setQty($qty);
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
}
