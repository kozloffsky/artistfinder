<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Media;
use Acted\LegalDocsBundle\Entity\Offer;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Entity\PaymentSetting;
use Acted\LegalDocsBundle\Form\ArtistType;
use Acted\LegalDocsBundle\Form\MediaUploadType;
use Acted\LegalDocsBundle\Form\OfferType;
use Acted\LegalDocsBundle\Form\ProfileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Acted\LegalDocsBundle\Form\ProfileSettingsType;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use FOS\RestBundle\Controller\Annotations as Rest;

class ProfileController extends Controller
{
    public function sortPerformancesByPrice($data) {
        $performances = $data;
        $priceOnRequestFlag = true;

        foreach($performances->getItems() as &$performance) {
            $packages = $performance->getPackages()->getValues();
            $amountArray = [];
            $currentPerformancePrice = 3000;

            foreach($packages as $package) {
                $options = $package->getOptions()->getValues();

                foreach($options as $option) {
                    $priceOnRequest = $option->getPriceOnRequest();

                    if (empty($option->getDeletedTime())) {
                        $priceOnRequestFlag = $priceOnRequest & $priceOnRequestFlag;
                    }

                    $rates = $option->getRates()->getValues();
                    foreach($rates as $rate) {
                        if (!empty($rate->getDeletedTime())) {
                            continue;
                        }

                        $amount = $rate->getPrice()->getAmount();
                        $amountArray[] = $amount;
                        $currentPerformancePrice = min($amountArray);
                    }
                }
            }

            $performance->setMinPrice($currentPerformancePrice);
            $performance->setPriceOnRequest($priceOnRequestFlag);
        }

        return $performances;
    }

    public function showAction(Request $request, Artist $artist) {
        $em = $this->getDoctrine()->getManager();

        $categoriesRepo = $em->getRepository('ActedLegalDocsBundle:Category');
        $categories = $categoriesRepo->childrenHierarchy();

        $user = $this->getUser();

        if ($user) {
            if ($user->getRoles()[0] !== 'ROLE_ADMIN' && !($artist->getUser()->getActive())) {
                return $this->redirect($this->generateUrl('acted_legal_docs_homepage'));
            }
        } else {
            if (!($artist->getUser()->getActive())) {
                return $this->redirect($this->generateUrl('acted_legal_docs_homepage'));
            }
        }


        $perf = $this->getPerformances($artist, $request->get('page', 1), true);
        $performances = $this->sortPerformancesByPrice($perf);
        $feedbacks = $this->getFeedbacks($artist, 1);

        return $this->render('ActedLegalDocsBundle:Profile:show.html.twig',
            compact('artist', 'user', 'performances', 'feedbacks', 'categories')
        );
    }

    public function editProfileAction(Request $request, Artist $artist)
    {
        $user = $this->getUser();
        /** Check if Admin */
        $admin = false;
        if ($user) {
            $admin = $user->getRoles()[0] === 'ROLE_ADMIN' ? true: false;
        }

        if (!$admin) {
            if ((!$user || $user->getArtist()->getSlug() !== $artist->getSlug())) {
                return $this->redirect($this->generateUrl('acted_legal_docs_homepage'));
            }
        }


        $em = $this->getDoctrine()->getManager();

        $categoriesRepo = $em->getRepository('ActedLegalDocsBundle:Category');
        $categories = $categoriesRepo->childrenHierarchy();


        $perf = $this->getPerformances($artist, $request->get('page', 1), true);
        $performances = $this->sortPerformancesByPrice($perf);
        $feedbacks = $this->getFeedbacks($artist, 1);

        return $this->render('ActedLegalDocsBundle:Profile:profile_edit.html.twig',
            compact('artist', 'user', 'performances', 'feedbacks', 'categories')
        );
    }

    public function editProfilePaginationPerformanceAction(Request $request, Artist $artist)
    {
        $perf = $this->getPerformances($artist, $request->get('page', 1), true);
        $performances = $this->sortPerformancesByPrice($perf);

        return $this->render('@ActedLegalDocs/Profile/ordersSectionEdit.html.twig',
            compact('artist', 'performances')
        );
    }

    public function editAction(Request $request, Artist $artist)
    {
        $artistForm = $this->createForm(ArtistType::class, $artist);
        $artistForm->handleRequest($request);
        $profileForm = $this->createForm(ProfileType::class, $artist->getUser()->getProfile());
        $profileForm->handleRequest($request);

        if($artistForm->isSubmitted() && $artistForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artist);
            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        if($profileForm->isSubmitted() && $profileForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artist->getUser()->getProfile());
            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        if($artistForm->isSubmitted()) {
            return new JsonResponse($this->formErrorResponse($artistForm));
        }

        return new JsonResponse($this->formErrorResponse($profileForm));
    }

    public function performancesAction(Request $request, Artist $artist)
    {
        $performances = $this->getPerformances($artist, $request->get('page', 1), true);
        return $this->render('@ActedLegalDocs/Profile/ordersSection.html.twig', compact('performances', 'artist'));
    }

    public function offerEditAction(Request $request, Offer $offer)
    {
        $offerForm = $this->createForm(OfferType::class, $offer);
        $offerForm->handleRequest($request);

        if($offerForm->isSubmitted() && $offerForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse($this->formErrorResponse($offerForm));
    }

    public function feedbacksAction(Request $request, Artist $artist)
    {
        $feedbacks = $this->getFeedbacks($artist,  $request->get('page', 1));
        return $this->render('@ActedLegalDocs/Profile/feedbacksSection.html.twig', compact('feedbacks', 'artist'));
    }

    /**
     * @ParamConverter("artist", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("media", options={"mapping": {"id": "id"}})
     */
    public function addMediaAction(Artist $artist, Media $media)
    {
        $profile = $artist->getUser()->getProfile();

        if(!$profile->getMedia()->contains($media)) {
            $em = $this->getDoctrine()->getManager();
            $profile->addMedia($media);
            $em->flush();
        }

        return new JsonResponse(['status' => 'success']);
    }

    /**
     * @ParamConverter("artist", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("performance", options={"mapping": {"id": "id"}})
     */
    public function deletePerformanceAction(Artist $artist, Performance $performance)
    {
        if($artist->getUser()->getProfile()->getPerformances()->contains($performance)){
            $em = $this->getDoctrine()->getManager();
            $em->remove($performance);
            $em->flush();
        }

        return new JsonResponse(['status' => 'success']);
    }

    public function newMediaAction(Request $request, Artist $artist)
    {
        $serializer = $this->get('jms_serializer');
        $form = $this->createForm(MediaUploadType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $mediaManager = $this->get('app.media.manager');
            $media = new Media();

            if(!is_null($data['video'])) {
                if (strripos($data['video'], 'youtube.com') === false && strripos($data['video'], 'vimeo.com') === false
                    &&  strripos($data['video'], 'youtu.be') === false ) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Added link should be from youtube.com or vimeo.com'
                    ],  400);
                }
                $media = $mediaManager->updateVideo($data['video'], $media);
            } elseif(!is_null($data['audio'])) {
                if (strripos($data['audio'], 'soundcloud.com') === false || strripos($data['audio'], 'iframe') === false) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Added link should be from soundcloud.com embed'
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

            $em->persist($media);
            $artist->getUser()->getProfile()->addMedia($media);

            $em->flush();

            return new JsonResponse(['status' => 'success', 'media' => $serializer->toArray($media)]);
        }

        return new JsonResponse($serializer->toArray($form->getErrors()));
    }

    /**
     * @ParamConverter("artist", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("media", options={"mapping": {"id": "id"}})
     */
    public function deleteMediaAction(Artist $artist, Media $media)
    {
        $profile = $artist->getUser()->getProfile();

        if($profile->getMedia()->contains($media)) {
            $em = $this->getDoctrine()->getManager();
            $profile->removeMedia($media);
            $em->remove($media);
            $em->flush();
        }

        return new JsonResponse(['status' => 'success']);
    }

    private function getPerformances(Artist $artist, $page, $status)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        return $paginator->paginate(
            $em->getRepository('ActedLegalDocsBundle:Performance')->findByArtistQuery($artist, $status),
            $page,
            $this->getParameter('per_page')
        );
    }

    private function getFeedbacks(Artist $artist, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        return $paginator->paginate(
            $em->getRepository('ActedLegalDocsBundle:Feedback')->findByArtistQuery($artist),
            $page,
            $this->getParameter('per_page')
        );
    }

    public function listAction()
    {
        $entities = $this->getDoctrine()->getManager()->getRepository('ActedLegalDocsBundle:Artist')->findAll();
        return $this->render('ActedLegalDocsBundle:Profile:list.html.twig', ['entities' => $entities]);
    }

    public function getProfileSettingsAction(Request $request, Artist $artist)
    {
        $serializer = $this->get('jms_serializer');
        return new JsonResponse(['status' => 'success', 'artist' => $serializer->toArray($artist, SerializationContext::create()
            ->setGroups(['profile_settings']))]);
    }

    public function editProfileSettingsAction(Request $request, Artist $artist)
    {
        $serializer = $this->get('jms_serializer');

        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('app.user.manager');
        $user = $artist->getUser();

        $profileSettingsForm = $this->createForm(ProfileSettingsType::class);
        $profileSettingsForm->handleRequest($request);

        if ($profileSettingsForm->isSubmitted() && (!$profileSettingsForm->isValid())) {
            return new JsonResponse($serializer->toArray($profileSettingsForm->getErrors(true)), Response::HTTP_BAD_REQUEST);
        }

        $data = $profileSettingsForm->getData();

        /*if (!empty($data['email'])) {
            $user = $em->getRepository('ActedLegalDocsBundle:User')->findOneBy(array('email' => $data['email'], 'id' => $user->getId()));

            if (!empty($user)) {
                return new JsonResponse(['form' => ['children' => ['email' => ['errors' => [0 =>'User with email '. $data['email'] . ' already exist.']]]] ], Response::HTTP_BAD_REQUEST);
            }
        }*/

        $file = $data['file'];
        if (!empty($file)) {

            if (!in_array($file->getExtension(), ['png', 'jpg', 'jpeg'])) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'You should upload only png or jpg images'
                ],  400);
            }

            $artist = $userManager->updateSearchImage($file, $artist, $request);
        }

        $data['post_code'] = (empty($data['post_code']) ? '' : $data['post_code']);
        $data['account_name'] = (empty($data['account_name']) ? '' : $data['account_name']);
        $data['account_number'] = (empty($data['account_number']) ? '' : $data['account_number']);
        $data['bank_name'] = (empty($data['bank_name']) ? '' : $data['bank_name']);
        $data['billing_address'] = (empty($data['billing_address']) ? '' : $data['billing_address']);
        $data['iban'] = (empty($data['iban']) ? '' : $data['iban']);
        $data['swift_code'] = (empty($data['swift_code']) ? '' : $data['swift_code']);
        $data['vat_number'] = (empty($data['vat_number']) ? '' : $data['vat_number']);

        $user->setFirstname($data['first_name']);
        $user->setLastname($data['last_name']);
        $user->setPostcode($data['post_code']);
        $user->setPrimaryPhone($data['phone']);

        if (!empty($data['password'])) {
            $user = $userManager->updatePassword($user, $data['password']);
        }

        $em->persist($user);


        $refCountryRepo = $em->getRepository('ActedLegalDocsBundle:RefCountry');
        $countryId = $refCountryRepo->createCountry($data['country']);

        $country = $em->getRepository('ActedLegalDocsBundle:RefCountry')->findOneBy(array(
            'id' => $countryId
        ));

        $refRegionRepo = $em->getRepository('ActedLegalDocsBundle:RefRegion');
        $regionId = $refRegionRepo->createRegion($data['region_name'], $country, $data['region_lat'], $data['region_lng']);

        $region = $em->getRepository('ActedLegalDocsBundle:RefRegion')->findOneBy(array(
            'id' => $regionId
        ));

        $refCityRepo = $em->getRepository('ActedLegalDocsBundle:RefCity');
        $cityId = $refCityRepo->createCity($data['city'], $region, $data['city_lat'], $data['city_lng']);

        $city = $em->getRepository('ActedLegalDocsBundle:RefCity')->findOneBy(array(
            'id' => $cityId
        ));

        $artist->setName($data['name']);
        $artist->setCountry($country);
        $artist->setCity($city);
        $artist->setWorkAbroad($data['work_abroad']);

        $paymentSettingRepo = $em->getRepository('ActedLegalDocsBundle:PaymentSetting');

        $paymentSettingObj = $paymentSettingRepo->findOneBy(array(
            'user' => $user
        ));

        if (empty($paymentSettingObj)) {
            $paymentSettingObj = new PaymentSetting();
        }

        $paymentSettingObj->setAccountName($data['account_name']);
        $paymentSettingObj->setAccountNumber($data['account_number']);
        $paymentSettingObj->setBankName($data['bank_name']);
        $paymentSettingObj->setBillingAddress($data['billing_address']);
        $paymentSettingObj->setIban($data['iban']);
        $paymentSettingObj->setSwiftCode($data['swift_code']);
        $paymentSettingObj->setVatNumber($data['vat_number']);
        $paymentSettingObj->setUser($user);

        $em->persist($paymentSettingObj);

        $em->flush();

        return new JsonResponse(['status' => 'success', 'artist' => $serializer->toArray($artist, SerializationContext::create()
            ->setGroups(['profile_settings']))]);
    }

    public function getCurrentProfileSettingsAction() {
        $artist = $this->getUser()->getArtist();
        $serializer = $this->get('jms_serializer');

        $artist_id = $artist->getId();

        $artist = $serializer->toArray($artist, SerializationContext::create()->setGroups(['profile_settings']));

        $domain = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];

        return $this->render('ActedLegalDocsBundle:Profile:settings.html.twig', compact('artist', 'artist_id', 'domain'));
    }

    /**
     * switch showing feedbacks
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get feedback",
     *  input="Acted\LegalDocsBundle\Form\FeedbackRatingCreateType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function switchShowingFeedbacksAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $profileId = $this->getUser()->getProfile()->getId();

        $profileRepo = $em->getRepository('ActedLegalDocsBundle:Profile');
        $profileRepo->switchFeedbacks($profileId);

        return new JsonResponse(array('status' => 'success'), Response::HTTP_OK);
    }
}
