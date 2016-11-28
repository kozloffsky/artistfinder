<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Media;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Entity\Package;
use Acted\LegalDocsBundle\Entity\Option;
use Acted\LegalDocsBundle\Entity\Price;
use Acted\LegalDocsBundle\Entity\Rate;
use Acted\LegalDocsBundle\Entity\PerformanceRequestQuotation;
use Acted\LegalDocsBundle\Form\MediaUploadType;
use Acted\LegalDocsBundle\Form\PerformanceType;
use Acted\LegalDocsBundle\Form\PerformancePriceType;
use Acted\LegalDocsBundle\Form\PriceRateCreateType;
use Acted\LegalDocsBundle\Form\PerformancePricePackageType;
use Symfony\Component\HttpFoundation\Response;
use Acted\LegalDocsBundle\Model\MediaManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;

class PerformanceController extends Controller
{
    public function newAction(Request $request, Artist $artist)
    {
        $performance = new Performance();
        $performanceForm = $this->createForm(PerformanceType::class, $performance, ['method' => 'POST']);
        $performanceForm->handleRequest($request);

        if($performanceForm->isSubmitted() && $performanceForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $performance->setProfile($artist->getUser()->getProfile());
            if ($performance->getStatus() === Performance::STATUS_PUBLISHED) {
                if (!$performance->getMedia()) {
                    return new JsonResponse(['error' => 'Performance can not be published without media'], 400);
                }
            }

            $performanceData = $performanceForm->getData();

            if (empty($performanceData->getType())) {
                $performance->setType(Performance::TYPE_BASE);
            }

            $em->persist($performance);

            $profile = $artist->getUser()->getProfile();
            $package = new Package();
            $package->setProfile($profile);
            $package->setPerformance($performance);
            $package->setName('default package');
            $em->persist($package);

            $option = new Option();
            $option->setPackage($package);
            $em->persist($option);

            $price = new Price();
            $price->setAmount(3000);
            $em->persist($price);

            $rate = new Rate();
            $rate->setOption($option);
            $rate->setPrice($price);
            $em->persist($rate);

            $performance->setIsVisible(true);

            $em->flush();
            $serializer = $this->get('jms_serializer');
            return new JsonResponse(['status' => 'success', 'performance' => $serializer->toArray($performance, SerializationContext::create()
                ->setGroups(['performance_create']))]);
        }

        return new JsonResponse($this->formErrorResponse($performanceForm));
    }

    public function editAction(Request $request, Performance $performance)
    {
        $mediaForm = $this->createForm(PerformanceType::class, $performance, ['method' => 'PATCH']);
        $mediaForm->handleRequest($request);

        if($mediaForm->isSubmitted() && $mediaForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ($performance->getStatus() === Performance::STATUS_PUBLISHED) {
                if (!$performance->getMedia()) {
                    return new JsonResponse(['error' => 'Performance can not be published without media'], 400);
                }
            }
            $em->persist($performance);

            $performance->setIsVisible(true);

            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse($this->formErrorResponse($mediaForm));
    }

    public function newMediaAction(Request $request, Performance $performance)
    {
        $serializer = $this->get('jms_serializer');
        $form = $this->createForm(MediaUploadType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $mediaManager = $this->get('app.media.manager');
            $media = new Media();
            $performance->addMedia($media);

            $validator = $this->get('validator');
            $validationErrors = $validator->validate($performance);

            if (count($validationErrors) > 0) {
                return new JsonResponse($serializer->toArray($validationErrors), 400);
            }

            if(!is_null($data['video'])) {
                if (strripos($data['video'], 'youtube.com') === false && strripos($data['video'], 'vimeo.com') === false
                    &&  strripos($data['video'], 'youtu.be') === false ) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Added link should be from "youtube.com" or "vimeo.com"'
                    ],  400);
                }
                $media = $mediaManager->updateVideo($data['video'], $media);
            } elseif(!is_null($data['audio'])) {
                if (strripos($data['audio'], 'soundcloud.com') === false || strripos($data['audio'], 'iframe')) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Added link should be from "soundcloud.com" embed'
                    ],  400);
                }
                $media = $mediaManager->updateAudio($data['audio'], $media);
            } else {
                /** @var UploadedFile $file */
                $file = $data['file'];
                if (!in_array($file->getExtension(), ['png', 'jpg', 'jpeg'])) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'You should upload only png or jpg images'
                    ],  400);
                }
                $media = $mediaManager->updatePhoto($file, $media, $request);
            }

            if (isset($data['position']) && !empty($data['position'])) {
                $media->setPosition($data['position']);
            }
            $em->persist($media);
            $em->flush();

            return new JsonResponse(['status' => 'success', 'media' => $serializer->toArray($media)]);
        }

        return new JsonResponse($serializer->toArray($form->getErrors()));
    }

    public function createPricePerformanceAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $performancePriceForm = $this->createForm(PerformancePriceType::class, null, ['method' => 'POST']);
        $performancePriceForm->handleRequest($request);

        if ($performancePriceForm->isSubmitted() && (!$performancePriceForm->isValid())) {
            return new JsonResponse($serializer->toArray($performancePriceForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('app.user.manager');

        $performance = new Performance();

        $data = $performancePriceForm->getData();

        if (empty($data)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'There are not any data'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $artist = $data['artist'];
        $comment = $data['comment'];
        $type = Performance::TYPE_BASE;

        if (!empty($data['type'])) {
            $type = $data['type'];
        }

        $profile = $artist->getUser()->getProfile();

        $performance->setTitle($data['title']);
        $performance->setProfile($profile);
        $performance->setStatus(Performance::STATUS_PUBLISHED);
        $performance->setIsVisible(false);
        $performance->setIsQuotation($data['is_quotation']);
        $performance->setType($type);
        $performance->setComment($comment);
        $em->persist($performance);

        $package = new Package();
        $package->setProfile($profile);
        $package->setPerformance($performance);
        $package->setName($data['package_name']);
        $em->persist($package);

        foreach ($data['options'] as $currentOption) {
            /*If it performance has base type or extra performance with standard type*/
            if (($type == Performance::TYPE_BASE || $type == Performance::TYPE_STANDARD) &&
                (empty($currentOption['duration']) || empty($currentOption['qty']))) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'duration or qty is empty'
                ],  Response::HTTP_BAD_REQUEST);
            }

            $duration = null;
            $qty = null;

            if ($type == Performance::TYPE_BASE || $type == Performance::TYPE_STANDARD) {
                $duration = $currentOption['duration'];
                $qty = $currentOption['qty'];
            }

            $option = new Option();
            $option->setPackage($package);
            $option->setDuration($duration);
            $option->setQty($qty);
            $option->setPriceOnRequest($currentOption['price_on_request']);
            $em->persist($option);

            $price = new Price();
            $price->setAmount($currentOption['price1']);
            $em->persist($price);

            $rate = new Rate();
            $rate->setOption($option);
            $rate->setPrice($price);
            $em->persist($rate);

            if (!empty($currentOption['price2'])) {
                $price = new Price();
                $price->setAmount($currentOption['price2']);
                $em->persist($price);

                $rate = new Rate();
                $rate->setOption($option);
                $rate->setPrice($price);
                $em->persist($rate);
            }
        }

        $em->flush();

        $performanceRepo = $em->getRepository('ActedLegalDocsBundle:Performance');

        $createdPerformance = $performanceRepo->getFullPerformanceById($performance->getId());
        if (!empty($createdPerformance)) {
            $createdPerformance = $createdPerformance[0];
        }

        if ($data['is_quotation']) {
            $performanceRequestQuotation = new PerformanceRequestQuotation();
            $performanceRequestQuotation->setPerformance($performance);
            $performanceRequestQuotation->setRequestQuotation($data['request_quotation']);
            $em->persist($performanceRequestQuotation);
            $em->flush();
        }

        return new JsonResponse(['status' => 'success', 'performance' => $createdPerformance]);
    }

    public function editPricePerformanceAction(Request $request, Performance $performance)
    {
        $serializer = $this->get('jms_serializer');
        $performanceFrom = $this->createForm(PerformanceType::class, $performance, ['method' => 'PATCH']);
        $performanceFrom->handleRequest($request);

        if ($performanceFrom->isSubmitted() && (!$performanceFrom->isValid())) {
            return new JsonResponse($serializer->toArray($performanceFrom->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $performanceData = $performanceFrom->getData();
        $performance->setTitle($performanceData->getTitle());
        $performance->setType($performanceData->getType());
        $performance->setComment($performanceData->getComment());

        $em->persist($performance);
        $em->flush();

        return new JsonResponse(array('status' => 'success'));
    }

    public function removePricePerformanceAction(Request $request, Performance $performance)
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
            $packageIds = $packageRepository->getPackageIdsByPerformanceId($performance->getId());
            $optionIds = $optionRepository->getOptionIdsByPackageIds($packageIds);
            $rateIds = $rateRepository->getRateIdsByOptionIds($optionIds);

            $performanceRepository->removePerformances($performance->getId());

            $packageRepository->removePackages($packageIds);

            $optionRepository->removeOptions($optionIds);
            $rateRepository->removeRates($rateIds);
            $em->flush();

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Edit error'
            ],  Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(array('status' => 'success'));
    }

    public function getListAction(Request $request, Artist $artist)
    {
        $serializer = $this->get('jms_serializer');

        $repository = $this->getDoctrine()
            ->getRepository('ActedLegalDocsBundle:Performance');

        $performances = $repository->getPerformancesByProfileId($artist->getUser()->getProfile());

        return new JsonResponse(array('performances' => $performances), Response::HTTP_OK);
    }

    public function getAction(Request $request, Performance $performance = null)
    {
        if (empty($performance)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Performance is not found'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $serializer = $this->get('jms_serializer');

        $repository = $this->getDoctrine()
            ->getRepository('ActedLegalDocsBundle:Performance');

        $performance = $repository->getFullPerformanceById($performance->getId());

        if (!empty($performance)) {
            $performance = $performance[0];
        }

        return new JsonResponse(array('performance' => $performance), Response::HTTP_OK);
    }

    public function createPricePerformancePackageAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $performancePricePackageForm = $this->createForm(PerformancePricePackageType::class, null, ['method' => 'POST']);
        $performancePricePackageForm->handleRequest($request);

        if ($performancePricePackageForm->isSubmitted() && (!$performancePricePackageForm->isValid())) {
            return new JsonResponse($serializer->toArray($performancePricePackageForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->beginTransaction();

        try {
            $data = $performancePricePackageForm->getData();

            if (empty($data)) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'There are not any data'
                ],  Response::HTTP_BAD_REQUEST);
            }

            $artist = $data['artist'];
            $performance = $data['performance'];
            $profile = $artist->getUser()->getProfile();

            $package = new Package();
            $package->setProfile($profile);
            $package->setPerformance($performance);
            $package->setName($data['package_name']);
            $em->persist($package);

            foreach ($data['options'] as $currentOption) {
                $option = new Option();
                $option->setPackage($package);
                $option->setDuration($currentOption['duration']);
                $option->setQty($currentOption['qty']);
                $option->setPriceOnRequest($currentOption['price_on_request']);
                $em->persist($option);

                $price = new Price();
                $price->setAmount($currentOption['price1']);
                $em->persist($price);

                $rate = new Rate();
                $rate->setOption($option);
                $rate->setPrice($price);
                $em->persist($rate);

                if (!empty($currentOption['price2'])) {
                    $price = new Price();
                    $price->setAmount($currentOption['price2']);
                    $em->persist($price);

                    $rate = new Rate();
                    $rate->setOption($option);
                    $rate->setPrice($price);
                    $em->persist($rate);
                }
            }

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

    public function createPricePerformanceRateAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $performancePriceRateCreateForm = $this->createForm(PriceRateCreateType::class, null, ['method' => 'POST']);
        $performancePriceRateCreateForm->handleRequest($request);

        if ($performancePriceRateCreateForm->isSubmitted() && (!$performancePriceRateCreateForm->isValid())) {
            return new JsonResponse($serializer->toArray($performancePriceRateCreateForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $em->getConnection()->beginTransaction();

        try {
            $data = $performancePriceRateCreateForm->getData();

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

            //check what count prices in option and if more than 1 than show error
            $rateIds = $rateRepository->getRateIdsByOptionIds($optionId);
            if (count($rateIds) > 1) {
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

        return new JsonResponse(array('status' => 'success', 'price' => ['id' => $price->getId()]));
    }
}
