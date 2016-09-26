<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Price;
use Acted\LegalDocsBundle\Form\PriceRateEditType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Acted\LegalDocsBundle\Entity\Rate;
use Symfony\Component\HttpFoundation\Request;

class PriceRateController extends Controller
{
    public function editAction(Request $request, Rate $rate)
    {
        $serializer = $this->get('jms_serializer');

        $priceRateEditForm = $this->createForm(PriceRateEditType::class, null, ['method' => 'PATCH']);
        $priceRateEditForm->handleRequest($request);

        if ($priceRateEditForm->isSubmitted() && (!$priceRateEditForm->isValid())) {
            return new JsonResponse($serializer->toArray($priceRateEditForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('app.user.manager');

        $em->getConnection()->beginTransaction();

        /*Begin transcation*/
        try {
            $data = $priceRateEditForm->getData();
            $priceAmount = $data['price'];

            $priceRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Price');

            $rateRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Rate');

            $priceId = $rateRepository->getPriceIdsByRateIds($rate->getId());
            if (empty($priceId)) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'There is not price with that id'
                ],  Response::HTTP_BAD_REQUEST);
            }

            $priceRepository->updatePriceById($priceId, $priceAmount);

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Update error'
            ],  Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(array('status' => 'success'));
    }

    public function removeAction(Request $request, Rate $rate)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->beginTransaction();
        /*Begin transcation*/
        try {
            $rateRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Rate');

            $rateRepository->removeRates($rate->getId());

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Remove error'
            ],  Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(array('status' => 'success'));
    }
}
