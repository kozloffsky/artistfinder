<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Recommend;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Entity\Media;
use Acted\LegalDocsBundle\Form\CreateUserType;
use Acted\LegalDocsBundle\Form\RecommendType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Popo\RegisterUser;

class AdminController extends Controller
{

    public function indexAction()
    {
        return $this->render('ActedLegalDocsBundle:Admin:index.html.twig', []);
    }
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function recommendAction(Request $request)
    {
        $page = $request->get('page');
        $artistRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:Artist');
        $serializer = $this->get('jms_serializer');
        $paginator  = $this->get('knp_paginator');
        $query = $request->get('query');
        $start = $request->get('start');
        $end = $request->get('end');
        $mainCat = $request->get('main');
        $filters = [
            'query' => $query,
            'start' => $start,
            'end' => $end,
            'main' => $mainCat ? $mainCat : 1
        ];
        $categories = $this->getEM()->getRepository('ActedLegalDocsBundle:Category')->getRecommended();
        if (!$mainCat) {
            $mainCat = $categories[0]->getId();
        }


        $artistsQuery = $artistRepo->getArtistsList($query, $start, $end, true, false, null, $mainCat);
        $data = $paginator->paginate($artistsQuery, $page, 30);

        $artists = $serializer->toArray($data->getItems(), SerializationContext::create()
            ->setGroups(['recommend_artist']));
        $paginations = $data->getPaginationData();

        return $this->render('ActedLegalDocsBundle:Admin:recommend.html.twig',
           compact('artists', 'paginations', 'filters', 'categories')
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function spotlightAction(Request $request)
    {
        $page = $request->get('page');
        $artistRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:Artist');
        $serializer = $this->get('jms_serializer');
        $paginator  = $this->get('knp_paginator');
        $query = $request->get('query');
        $start = empty($request->get('start')) ? $request->get('start'): 1;
        $end = $request->get('end');

        $filters = [
            'query' => $query,
            'start' => $start,
            'end' => $end
        ];

        $artistsQuery = $artistRepo->getArtistsList($query, $start, $end, false, true, null);
        $data = $paginator->paginate($artistsQuery, $page, 30);

        $artists = $serializer->toArray($data->getItems(), SerializationContext::create()
            ->setGroups(['spotlight_artist']));
        $paginations = $data->getPaginationData();

        return $this->render('ActedLegalDocsBundle:Admin:spotlight.html.twig',
            compact('artists', 'paginations', 'filters')
        );
    }

    /**
     * change recommend
     * @ApiDoc(
     *  description="Change Recommend",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when not exist offer",
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeRecommendValueAction(Request $request)
    {
        $form = $this->createForm(RecommendType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $recommendRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:Recommend');
            $artist = $recommendRepo->findOneBy(['artist' => $data->getArtist(), 'category' => $data->getCategory()]);
            if ($data->getValue() === 0 && $artist) {
                $this->getEM()->remove($artist);
                $this->getEM()->flush();

                return new JsonResponse(['success' => 'Recommendation was changed!']);
            }
            $recommends = $recommendRepo->findRecommendByData($data->getCategory(), $data->getArtist(),
                $data->getValue());

            if ($artist) {
                $artist->setValue($data->getValue());
            } else {
                $artist = new Recommend();
                $artist->setValue($data->getValue());
                $artist->setCategory($data->getCategory());
                $artist->setArtist($data->getArtist());
            }
            $this->getEM()->persist($artist);
            $this->getEM()->flush();
            $recommendData = $data->getValue();

            foreach ($recommends as $recommend) {
                $recommendData++;
                if ($recommendData < 101) {
                    $recommend->setValue($recommendData);
                    $this->getEM()->persist($recommend);
                } else {
                    $this->getEM()->remove($recommend);
                }
            }

            $this->getEM()->flush();
        } else {
            $errors = array();

            foreach ($form->getErrors(true) as $key => $error) {
                $errors[] = $error->getMessage();
            }

            return new JsonResponse(['error' => $errors], 400);
        }

        return new JsonResponse(['success' => 'Recommendation was changed!']);
    }

    /**
     * Change spotlight
     * @ApiDoc(
     *  description="Change Spotlight",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when not exist offer",
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeSpotlightValueAction(Request $request)
    {
        $artistId = $request->get('id');

        $spotlight = $request->get('spotlight');

        if ((int)$spotlight < 0 ) {
            return new JsonResponse(['error' => 'You should set only positive spotlight value'], 400);
        }
        $artistRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:Artist');

        $curArtist = $artistRepo->find($artistId);
        if ((int)$spotlight === 0) {
            $curArtist->setSpotlight(0);
            $this->getEM()->persist($curArtist);
            $this->getEM()->flush();

            return new JsonResponse(['success' => 'Spotlight was changed!']);
        }
        $artists = $artistRepo->getArtistsList(null, $spotlight, null, false, true, $artistId)->getResult();


        $curArtist->setSpotlight($spotlight);
        $this->getEM()->persist($curArtist);
        foreach ($artists as $artist) {
            $spotlight++;
            $artist->setSpotlight($spotlight);
            $this->getEM()->persist($artist);
        }

        $this->getEM()->flush();

        return new JsonResponse(['success' => 'Spotlight was changed!']);
    }

    /**
     * @param Request $request
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userListAction(Request $request, $page)
    {
        $serializer = $this->get('jms_serializer');
        $paginator  = $this->get('knp_paginator');
        $userRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:User');
        $query = str_replace('@', '', $request->get('query'));
        $role = $request->get('role');
        $fake = $request->get('fake');
        $userId = $request->get('userId');
        $filters = [
            'query' => $query,
            'role' => $role,
            'fake' => $fake,
            'userId' => $userId
        ];
        $curUserId = $this->getUser()->getId();
        $categories = $this->categoriesList();

        $usersQuery = $userRepo->getUsersList($query, $role, $curUserId, $fake, $userId);
        $data = $paginator->paginate($usersQuery, $page, 30);

        $users = $serializer->toArray($data->getItems(), SerializationContext::create()
            ->setGroups(['users_list']));
        $paginations = $data->getPaginationData();

        return $this->render('ActedLegalDocsBundle:Admin:usersList.html.twig',
            compact('users', 'paginations', 'filters', 'categories')
        );
    }

    /**
     * Create new user
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Create new user",
     *  input="Acted\LegalDocsBundle\Form\CreateUserType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     */
    public function createNewUserAction(Request $request)
    {
        $form = $this->createForm(CreateUserType::class);
        $form->handleRequest($request);
        $serializer = $this->get('jms_serializer');

        if($form->isSubmitted() && $form->isValid()) {
            /** @var RegisterUser $data */
            $data = $form->getData();

            $userManager = $this->get('app.user.manager');
            $validator = $this->get('validator');
            $em = $this->getDoctrine()->getManager();

            if($data->getFake() === 'false') {
                $data->setFake(false);
            } else {
                $data->setFake(true);
            }

            $user = $userManager->newUser($data);

            if ($data->getRole() == 'ROLE_ARTIST') {
                $user->setPrimaryPhone($data->getPhone());
            }

            $validationErrors = $validator->validate($user);
            $now = new \DateTime();
            $user->setCreatedAt($now);
            $user->setActive(false);
            $em->persist($user);

            if ($data->getRole() == 'ROLE_ARTIST') {
                $profile = $userManager->newProfile($data);
                $profile->setUser($user);
                $profile->setActive(true);
                $validationErrors->addAll($validator->validate($profile));


                $refCountryRepo = $em->getRepository('ActedLegalDocsBundle:RefCountry');
                $countryId = $refCountryRepo->createCountry($data->getCountry());

                $country = $em->getRepository('ActedLegalDocsBundle:RefCountry')->findOneBy(array(
                    'id' => $countryId
                ));

                $refRegionRepo = $em->getRepository('ActedLegalDocsBundle:RefRegion');
                $regionId = $refRegionRepo->createRegion(
                    $data->getRegionName(),
                    $country,
                    $data->getRegionLat(),
                    $data->getRegionLng()
                );

                $region = $em->getRepository('ActedLegalDocsBundle:RefRegion')->findOneBy(array(
                    'id' => $regionId
                ));

                $refCityRepo = $em->getRepository('ActedLegalDocsBundle:RefCity');
                $cityId = $refCityRepo->createCity(
                    $data->getCity(),
                    $region,
                    $data->getCityLat(),
                    $data->getCityLng(),
                    $data->getPlaceId()
                );

                $city = $em->getRepository('ActedLegalDocsBundle:RefCity')->findOneBy(array(
                    'id' => $cityId
                ));

                $data->setCity($city);
                $data->setCountry($country);



                $artist = $userManager->newArtist($data);
                $artist->setUser($user);
                $validationErrors->addAll($validator->validate($artist));

                $em->persist($profile);
                $em->persist($artist);
            }

            if (count($validationErrors) > 0) {
                $errors = $serializer->toArray($validationErrors);
                $prettyErrors = [];
                foreach($errors as $error) {
                    foreach($error as $key=>$value) {
                        $prettyErrors[$key] = $value;
                    }
                }
                return new JsonResponse($prettyErrors, 400);
            }

            $em->flush();
            if ($user->getEmail()) {
                $userManager->confirmationForCreatedUser($user);
            }

            if ($data->getRole() == 'ROLE_ARTIST') {
                /** careate default performance */
                $performance = new Performance();
                $performance->setTitle('draft');
                $performance->setStatus('draft');
                $performance->setProfile($profile);
                $performance->setTechRequirement('draft');

                $em->persist($performance);

                $photo1 = new Media();
                $photo1->setName(uniqid());
                $photo1->setMediaType('photo');
                $photo1->setLink('/images/31.png');
                $photo1->setPosition(1);
                $photo1->setActive(true);
                $em->persist($photo1);

                $performance->addMedia($photo1);

                $photo2 = new Media();
                $photo2->setName(uniqid());
                $photo2->setMediaType('photo');
                $photo2->setLink('/images/31.png');
                $photo2->setPosition(2);
                $photo2->setActive(true);
                $em->persist($photo2);

                $performance->addMedia($photo2);

                $em->flush();
            }

            return new JsonResponse($serializer->toArray($user));
        }

        return new JsonResponse($this->get('app.form_errors_serializer')->serializeFormErrors($form, false), 400);
    }

    /**
     * Resend confirmation token
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Resend confirmation token",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param integer $userId
     * @return JsonResponse
     */
    public function resendConfirmationTokenAction($userId)
    {
        $userRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:User');
        $userManager = $this->get('app.user.manager');
        $encoder = $this->get('security.password_encoder');
        $user = $userRepo->find($userId);
        if (!$user->getEmail()) {
            return new JsonResponse(['error' => 'User haven\'t email']);
        }

        if (is_null($user->getConfirmationToken())) {
            /** if not exist token - generate new token */
            $user->setConfirmationToken($userManager->generateToken());
        }

        $tempPass = 'Ab12'.uniqid();
        $user->setTempPassword($tempPass);
        $user->setPasswordHash($encoder->encodePassword($user, $tempPass));

        $now = new \DateTime();
        $user->setConfirmationPeriod($now);
        $user->setPasswordRequestedAt($now);
        $this->getEM()->persist($user);
        $this->getEM()->flush();

        try {
            $userManager->confirmationForCreatedUser($user);

            return new JsonResponse(['success' => 'Message was sent successfully!']);
        } catch (\Exception $exp) {
            return new JsonResponse(['error' => $exp->getMessage()], 400);
        }
    }

    /**
     * Delete user by id
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Delete user by id",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param User $user
     * @return JsonResponse
     */
    public function deleteUserAction(User $user)
    {
        $em = $this->getEM();
        $mediaManager = $this->container->get('app.media.manager');
        try {
            $messageFileRepo = $em->getRepository('ActedLegalDocsBundle:MessageFile');
            $messageFiles = $messageFileRepo->getFileByUser($user);
            if ($user->getRoles()[0] === 'ROLE_ARTIST'){
                $em->remove($user->getArtist());
                $mediaManager->removeFiles($user, $messageFiles);
            }else{
                $em->remove($user->getClient());

            }
            $em->remove($user);
            $em->flush();

            return new JsonResponse(['success' => 'User remove successfully']);
        } catch (\Exception $exp) {
            return new JsonResponse(['error' => $exp->getMessage()], 400);
        }

    }

    /**
     * Change status user
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Change status user status = activate|deactivate",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function changeStatusAction(Request $request, User $user)
    {
        try {
            switch ($request->get('status')){
                case 'activate':
                    $user->setActive(1);
                    $this->getEM()->persist($user);
                    $this->getEM()->flush();
                    break;
                case 'deactivate':
                    $user->setActive(0);
                    $this->getEM()->persist($user);
                    $this->getEM()->flush();
                    break;
            }

            return new JsonResponse(['success' => 'Status change successfully!']);
        } catch (\Exception $exp) {
            return new JsonResponse(['error' => $exp->getMessage()], 400);
        }

    }

        /**
     * Change status user
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Change fake user status = isFake|isNotFake",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function changeStatusFakeAction(Request $request, User $user)
    {
        try {
            switch ($request->get('fake')){
                case 'isFake':
                    $user->setFake(1);
                    $this->getEM()->persist($user);
                    $this->getEM()->flush();
                    break;
                case 'isNotFake':
                    $user->setFake(0);
                    $this->getEM()->persist($user);
                    $this->getEM()->flush();
                    break;
            }

            return new JsonResponse(['success' => 'Fake field change successfully!']);
        } catch (\Exception $exp) {
            return new JsonResponse(['error' => $exp->getMessage()], 400);
        }

    }

    /**
     * Change email user
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Change status user email",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function changeEmailAction(Request $request, User $user)
    {
        if (!$user) {
            return new JsonResponse(['error' => 'No exist user'], 400);
        }

        $email = $request->get('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse(['error' => 'Not valid email'], 400);
        }

        $existEmail = $this->getEM()->getRepository('ActedLegalDocsBundle:User')->findOneBy(['email' => $email]);
        if ($existEmail && $existEmail->getId() !== $user->getId()) {
            return new JsonResponse(['error' => 'Email already used'], 400);
        }
        if (!$user->getEmail()) {
            $encoder = $this->get('security.password_encoder');
            $userManager = $this->get('app.user.manager');
            $now = new \DateTime();
            $user->setCreatedAt($now);
            $tempPass = 'Ab12'.uniqid();
            $user->setTempPassword($tempPass);
            $user->setEmail($email);
            $user->setPasswordHash($encoder->encodePassword($user, $tempPass));
            $this->getEM()->persist($user);
            $this->getEM()->flush();
            $userManager->confirmationForCreatedUser($user);
        } else {
            $user->setEmail($email);
            $this->getEM()->persist($user);
            $this->getEM()->flush();
        }

        return new JsonResponse(['success' => 'Email change successfully!']);
    }

    /**
     * List of categories
     * @return array
     */
    public function categoriesList()
    {
        return $this
            ->getEM()
            ->getRepository('ActedLegalDocsBundle:Category')
            ->childrenHierarchy();

    }
}
