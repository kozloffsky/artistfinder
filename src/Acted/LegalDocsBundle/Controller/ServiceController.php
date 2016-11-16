<?php

namespace Acted\LegalDocsBundle\Controller;

use Doctrine\ORM\Query\ResultSetMapping;
use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Option;
use Acted\LegalDocsBundle\Entity\Package;
use Acted\LegalDocsBundle\Entity\Service;
use Acted\LegalDocsBundle\Entity\Price;
use Acted\LegalDocsBundle\Entity\ServiceRequestQuotation;
use Acted\LegalDocsBundle\Form\ServicePriceType;
use Acted\LegalDocsBundle\Form\ServicePricePackageType;
use Acted\LegalDocsBundle\Form\ServiceType;
use Acted\LegalDocsBundle\Form\PriceRateCreateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Acted\LegalDocsBundle\Entity\Rate;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;

class ServiceController extends Controller
{
    public function createPriceServiceAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();

        $service = new Service();
        $serviceForm = $this->createForm(ServicePriceType::class, null, ['method' => 'POST']);
        $serviceForm->handleRequest($request);

        if ($serviceForm->isSubmitted() && (!$serviceForm->isValid())) {
            return new JsonResponse($serializer->toArray($serviceForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $data = $serviceForm->getData();

        if (empty($data)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'There are not any data'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $artist = $data['artist'];
        $profile = $artist->getUser()->getProfile();

        $service->setTitle($data['title']);
        $service->setProfile($profile);
        $service->setIsVisible(false);
        $service->setIsQuotation($data['is_quotation']);
        $em->persist($service);

        $package = new Package();
        $package->setProfile($profile);
        $package->setService($service);
        $package->setName($data['package_name']);
        $em->persist($package);

        $option = new Option();
        $option->setPackage($package);
        $option->setPriceOnRequest($data['price_on_request']);
        $em->persist($option);

        $price = new Price();
        $price->setAmount($data['price']);
        $em->persist($price);

        $rate = new Rate();
        $rate->setOption($option);
        $rate->setPrice($price);
        $em->persist($rate);
        $em->flush();

        $serviceRepo = $em->getRepository('ActedLegalDocsBundle:Service');

        $createdService = $serviceRepo->getFullServiceById($service->getId());
        if (!empty($createdService)) {
            $createdService = $createdService[0];
        }

        if ($data['is_quotation']) {
            $serviceRequestQuotation = new ServiceRequestQuotation();
            $serviceRequestQuotation->setService($service);
            $serviceRequestQuotation->setRequestQuotation($data['request_quotation']);
            $em->persist($serviceRequestQuotation);
            $em->flush();
        }

        return new JsonResponse(['status' => 'success', 'service' => $createdService]);
    }

    public function editPriceServiceAction(Request $request, Service $service)
    {
        $serializer = $this->get('jms_serializer');

        $serviceForm = $this->createForm(ServiceType::class, null, ['method' => 'PATCH']);
        $serviceForm->handleRequest($request);

        if ($serviceForm->isSubmitted() && (!$serviceForm->isValid())) {
            return new JsonResponse($serializer->toArray($serviceForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $serviceData = $serviceForm->getData();
        $service->setTitle($serviceData->getTitle());
        $em->persist($service);
        $em->flush();

        return new JsonResponse(['status' => 'success']);
    }

    public function removePriceServiceAction(Request $request, Service $service)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->beginTransaction();

        try {
            $serviceRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Service');

            $packageRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Package');

            $optionRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Option');

            $rateRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Rate');
            $packageIds = $packageRepository->getPackageIdsByServiceId($service->getId());
            $optionIds = $optionRepository->getOptionIdsByPackageIds($packageIds);
            $rateIds = $rateRepository->getRateIdsByOptionIds($optionIds);

            $serviceRepository->removeServices($service->getId());

            $packageRepository->removePackages($packageIds);

            $optionRepository->removeOptions($optionIds);
            $rateRepository->removeRates($rateIds);

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

    public function getAction(Request $request, Service $service = null)
    {
        if (empty($service)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Service is not found'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $serializer = $this->get('jms_serializer');

        $repository = $this->getDoctrine()
            ->getRepository('ActedLegalDocsBundle:Service');

        $service = $repository->getFullServiceById($service->getId());

        if (!empty($service)) {
            $service = $service[0];
        }

        return new JsonResponse(array('service' => $service), Response::HTTP_OK);

    }

    public function getListAction(Request $request, Artist $artist)
    {
        $serializer = $this->get('jms_serializer');

        $repository = $this->getDoctrine()
            ->getRepository('ActedLegalDocsBundle:Service');

        $services = $repository->getServicesByProfileId($artist->getUser()->getProfile());


        return new JsonResponse(array('services' => $services) /*$serializer->toArray($services)*/, Response::HTTP_OK);
    }

    public function createPriceServicePackageAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $servicePricePackageForm = $this->createForm(ServicePricePackageType::class, null, ['method' => 'POST']);
        $servicePricePackageForm->handleRequest($request);

        if ($servicePricePackageForm->isSubmitted() && (!$servicePricePackageForm->isValid())) {
            return new JsonResponse($serializer->toArray($servicePricePackageForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->beginTransaction();

        try {
            $data = $servicePricePackageForm->getData();

            if (empty($data)) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'There are not any data'
                ],  Response::HTTP_BAD_REQUEST);
            }

            $artist = $data['artist'];
            $service = $data['service'];
            $profile = $artist->getUser()->getProfile();

            $package = new Package();
            $package->setProfile($profile);
            $package->setService($service);
            $package->setName($data['package_name']);
            $em->persist($package);

            $option = new Option();
            $option->setPackage($package);
            $option->setPriceOnRequest($data['price_on_request']);
            $em->persist($option);

            $price = new Price();
            $price->setAmount($data['price']);
            $em->persist($price);

            $rate = new Rate();
            $rate->setOption($option);
            $rate->setPrice($price);
            $em->persist($rate);
            $em->flush();

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Creating error'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $packageRepo = $em->getRepository('ActedLegalDocsBundle:Package');

        $createdPackage = $packageRepo->getFullPackageById($package->getId());
        if (!empty($createdPackage)) {
            $createdPackage = $createdPackage[0];
        }

        return new JsonResponse(['status' => 'success', 'package' => $createdPackage]);
    }

    public function createPriceServiceRateAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $servicePriceRateCreateForm = $this->createForm(PriceRateCreateType::class, null, ['method' => 'POST']);
        $servicePriceRateCreateForm->handleRequest($request);

        if ($servicePriceRateCreateForm->isSubmitted() && (!$servicePriceRateCreateForm->isValid())) {
            return new JsonResponse($serializer->toArray($servicePriceRateCreateForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->beginTransaction();

        try {
            $data = $servicePriceRateCreateForm->getData();

            if (empty($data)) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'There are not any data'
                ],  Response::HTTP_BAD_REQUEST);
            }

            $priceAmount = $data['price'];
            $option = $data['option'];
            $optionId = $option->getId();

            $rateRepository = $this->getDoctrine()
                ->getRepository('ActedLegalDocsBundle:Rate');

            //check what count prices in option and if more than 0 than show error
            $rateIds = $rateRepository->getRateIdsByOptionIds($optionId);
            if (count($rateIds) > 0) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Options already consists price'
                ],  Response::HTTP_BAD_REQUEST);
            }

            $price = new Price();
            $price->setAmount($priceAmount);
            $em->persist($price);

            $rate = new Rate();
            $rate->setOption($option);
            $rate->setPrice($price);
            $em->persist($rate);

            $em->flush();

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Creating error'
            ],  Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(array('status' => 'success'));
    }
}
