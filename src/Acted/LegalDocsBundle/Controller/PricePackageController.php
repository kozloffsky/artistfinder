<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Entity\Package;
use Acted\LegalDocsBundle\Form\PricePackageType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class PricePackageController extends Controller
{
    public function editAction(Request $request, Package $package)
    {
        $serializer = $this->get('jms_serializer');
        $pricePackageFrom = $this->createForm(PricePackageType::class, $package, ['method' => 'PATCH']);
        $pricePackageFrom->handleRequest($request);

        if ($pricePackageFrom->isSubmitted() && (!$pricePackageFrom->isValid())) {
            return new JsonResponse($serializer->toArray($pricePackageFrom->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $packageData = $pricePackageFrom->getData();
        $package->setName($packageData->getName());

        $em->persist($package);
        $em->flush();

        return new JsonResponse(array('status' => 'success'));
    }

    public function removeAction(Request $request, Package $package)
    {
        $serializer = $this->get('jms_serializer');

        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->beginTransaction();

        try {
            $performanceRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Performance');

            $packageRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Package');

            $optionRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Option');

            $rateRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Rate');

            $serviceRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Service');

            $optionIds = $optionRepository->getOptionIdsByPackageIds(array($package->getId()));
            $rateIds = $rateRepository->getRateIdsByOptionIds($optionIds);

            $packageRepository->removePackages(array($package->getId()));

            $optionRepository->removeOptions($optionIds);
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
     * Change selecting package
     *
     * @ApiDoc(
     *  resource=true,
     *  description="change selecting package",
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

        $packageRepo = $em->getRepository('ActedLegalDocsBundle:Package');
        $resultUpdating = $packageRepo->changePackageSelected($id);

        return new JsonResponse(['status' => 'success']);
    }
}
