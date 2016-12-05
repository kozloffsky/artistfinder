<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Price;
use Acted\LegalDocsBundle\Form\PriceRateEditType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Acted\LegalDocsBundle\Entity\Rate;
use Symfony\Component\HttpFoundation\Request;

use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

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

            if (empty($data)) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'There are not any data'
                ],  Response::HTTP_BAD_REQUEST);
            }

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

            $rateRepository->setIsSelectRateByOptionId($rate->getOption()->getId());

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

    /**
     * Set isSelect of Rate to true and another elements to false
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Set isSelect of Rate to true and another elements to false",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param Rate $rate
     * @return JsonResponse
     */
    public function selectRateAction(Request $request, Rate $rate)
    {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('app.user.manager');

        $em->getConnection()->beginTransaction();

        /*Begin transcation*/
        try {
            $rateRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Rate');

            $rateRepository->setIsSelectRateByOptionId($rate->getOption()->getId(), false);

            $rate->setIsSelected(true);
            $em->persist($rate);
            $em->flush();

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Setting isSelect error'
            ],  Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(array('status' => 'success'));
    }
}
