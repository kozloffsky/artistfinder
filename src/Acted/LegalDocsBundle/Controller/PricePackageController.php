<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Entity\Package;
use Acted\LegalDocsBundle\Form\PricePackageType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

            $package = $packageRepository->getPackageById($package->getId());

            if (!empty($package->getPerformance())) {
                $performancePackagesIds = $packageRepository->getPackageIdsByPerformanceId($package->getPerformance()->getId());

                //check - is this package last in performance
                if (count($performancePackagesIds) < 2) {
                    $performanceRepository->removePerformance($package->getPerformance()->getId());
                }
            }

            if (!empty($package->getService())) {
                $servicePackagesIds = $packageRepository->getPackageIdsByServiceId($package->getService()->getId());
                //check - is this package last in service
                if (count($servicePackagesIds) < 2) {
                    $serviceRepository->removeService($package->getService()->getId());
                }
            }

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
}
