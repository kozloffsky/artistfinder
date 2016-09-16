<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Option;
use Acted\LegalDocsBundle\Entity\Package;
use Acted\LegalDocsBundle\Entity\Service;
use Acted\LegalDocsBundle\Entity\Price;
use Acted\LegalDocsBundle\Form\ServiceType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Acted\LegalDocsBundle\Entity\PricePackage;
use Acted\LegalDocsBundle\Entity\PriceOption;
use Acted\LegalDocsBundle\Entity\Rate;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;

class ServiceController extends Controller
{
    public function createAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('app.user.manager');

        $service = new Service();
        $serviceForm = $this->createForm(ServiceType::class);
        $serviceForm->handleRequest($request);

        if ($serviceForm->isSubmitted() && (!$serviceForm->isValid())) {
            return new JsonResponse($serializer->toArray($serviceForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $data = $serviceForm->getData();
        $artist = $data['artist'];
        $profile = $artist->getUser()->getProfile();

        $service->setTitle($data['title']);
        $service->setProfile($profile);
        $service->setIsVisible(false);
        $em->persist($service);

        $package = new Package();
        $package->setProfile($profile);
        $package->setService($service);
        $package->setName($data['package_name']);
        $em->persist($package);

        $option = new Option();
        $option->setPackage($package);
        $option->setDuration($data['duration']);
        $option->setQty($data['qty']);
        $em->persist($option);

        $price = new Price();
        $price->setAmount($data['price']);
        $em->persist($price);

        $rate = new Rate();
        $rate->setOption($option);
        $rate->setPrice($price);
        $em->persist($rate);
        $em->flush();

        return new JsonResponse(array('serviceId'=>$service->getId()));
        //return new JsonResponse($serializer->toArray($artist));
    }

    public function createPackageAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('app.user.manager');

        $service = new Service();
        $serviceForm = $this->createForm(ServiceType::class);
        $serviceForm->handleRequest($request);

        if ($serviceForm->isSubmitted() && (!$serviceForm->isValid())) {
            return new JsonResponse($serializer->toArray($serviceForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }


        $data = $serviceForm->getData();
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
        $option->setDuration($data['duration']);
        $option->setQty($data['qty']);
        $em->persist($option);

        $price = new Price();
        $price->setAmount($data['price']);
        $em->persist($price);

        $rate = new Rate();
        $rate->setOption($option);
        $rate->setPrice($price);
        $em->persist($rate);
        $em->flush();

        return new JsonResponse(array('serviceId'=>$service->getId()));
    }

    public function editAction(Request $request, Service $service)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('app.user.manager');

        $serviceForm = $this->createForm(ServiceType::class, null, ['method' => 'PATCH']);
        $serviceForm->handleRequest($request);

        if ($serviceForm->isSubmitted() && (!$serviceForm->isValid())) {
            return new JsonResponse($serializer->toArray($serviceForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em->getConnection()->beginTransaction();
        /*Begin transcation*/
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
            $rateIds = $rateRepository->getRateIdsByOptionIds($packageIds);

            $serviceRepository->removeService($service->getId());

            $packageRepository->removePackages($packageIds);

            $optionRepository->removeOptions($optionIds);
            $rateRepository->removeRates($rateIds);

            $data = $serviceForm->getData();
            $artist = $data['artist'];

            $profile = $artist->getUser()->getProfile();

            $package = new Package();
            $package->setProfile($profile);
            $package->setService($service);
            $package->setName($data['package_name']);
            $em->persist($package);

            $option = new Option();
            $option->setPackage($package);
            $option->setDuration($data['duration']);
            $option->setQty($data['qty']);
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
            \Doctrine\Common\Util\Debug::dump($e->getMessage());exit;
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Save error'
            ],  Response::HTTP_BAD_REQUEST);
        }
        \Doctrine\Common\Util\Debug::dump('!!');exit;

       /* $em->getConnection()->beginTransaction();
        try {
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();

            return $this->view(array('error' => 'Save error'), Codes::HTTP_BAD_REQUEST);
        }*/


        \Doctrine\Common\Util\Debug::dump($res);exit;
//        $em = $this->getDoctrine()->getManager();
//        $packages = $em->getRepository("ActedLegalDocsBundle:Package")->
    }

    public function removeAction(Request $request, Service $service)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('app.user.manager');

        $serviceForm = $this->createForm(ServiceType::class, null, ['method' => 'PATCH']);
        $serviceForm->handleRequest($request);

        if ($serviceForm->isSubmitted() && (!$serviceForm->isValid())) {
            return new JsonResponse($serializer->toArray($serviceForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em->getConnection()->beginTransaction();
        /*Begin transcation*/
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
            $rateIds = $rateRepository->getRateIdsByOptionIds($packageIds);

            $serviceRepository->removeService($service->getId());

            $packageRepository->removePackages($packageIds);

            $optionRepository->removeOptions($optionIds);
            $rateRepository->removeRates($rateIds);

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            \Doctrine\Common\Util\Debug::dump($e->getMessage());exit;
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Remove error'
            ],  Response::HTTP_BAD_REQUEST);
        }
        \Doctrine\Common\Util\Debug::dump('!!');exit;

        /* $em->getConnection()->beginTransaction();
         try {
             $em->getConnection()->commit();
         } catch (\Exception $e) {
             $em->getConnection()->rollback();

             return $this->view(array('error' => 'Save error'), Codes::HTTP_BAD_REQUEST);
         }*/


        \Doctrine\Common\Util\Debug::dump($res);exit;
//        $em = $this->getDoctrine()->getManager();
//        $packages = $em->getRepository("ActedLegalDocsBundle:Package")->
    }

    public function getAction(Request $request, Service $service = null)
    {
        if (empty($service)) {
            return new JsonResponse(array());//error;
        }

        $serializer = $this->get('jms_serializer');

        /*$packageRepository = $this->getDoctrine()
            ->getRepository('ActedLegalDocsBundle:Package');
        $res = $packageRepository->getPackageIdsByServiceId($service->getId());*/

        return new JsonResponse($serializer->toArray('!!!'), Response::HTTP_OK);
        //\Doctrine\Common\Util\Debug::dump($service->getId());exit;
        /*$serviceRepository = $this->getDoctrine()
            ->getRepository('ActedLegalDocsBundle:Service');
        $packageRepository = $this->getDoctrine()
            ->getRepository('ActedLegalDocsBundle:Package');
        $res = $serviceRepository->getServiceById($service->getId());
        \Doctrine\Common\Util\Debug::dump($service->getId());exit;*/

    }

    public function getListAction(Request $request, Artist $artist)
    {
        $serializer = $this->get('jms_serializer');

        $repository = $this->getDoctrine()
            ->getRepository('ActedLegalDocsBundle:Service');

        $services = $repository->getServices($artist->getUser()->getProfile());


        /*
         $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();
         try {
             $em->getConnection()->commit();
         } catch (\Exception $e) {
             $em->getConnection()->rollback();

             return $this->view(array('error' => 'Save error'), Codes::HTTP_BAD_REQUEST);
         }*/

        return new JsonResponse($serializer->toArray($services), Response::HTTP_OK);
    }
}
