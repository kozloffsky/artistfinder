<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Media;
use Acted\LegalDocsBundle\Entity\Recommend;
use Acted\LegalDocsBundle\Form\RecommendType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Form\RegisterType;
use Acted\LegalDocsBundle\Popo\RegisterUser;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class AdminController extends Controller
{
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
            'main' => $mainCat
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
        $query = $request->get('query');
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
     *  input="Acted\LegalDocsBundle\Form\RegisterType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     */
    public function createNewUserAction(Request $request)
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);
        $serializer = $this->get('jms_serializer');

        if($form->isSubmitted() && $form->isValid()) {
            /** @var RegisterUser $data */
            $data = $form->getData();

            $userManager = $this->get('app.user.manager');
            $validator = $this->get('validator');
            $em = $this->getDoctrine()->getManager();

            $user = $userManager->newUser($data);

            if ($data->getRole() == 'ROLE_ARTIST') {
                $user->setPrimaryPhone($data->getPhone());
            }

            $validationErrors = $validator->validate($user);
            $now = new \DateTime();
            $user->setCreatedAt($now);
            $user->setPasswordRequestedAt($now);
            $user->setActive(true);
            $em->persist($user);

            if ($data->getRole() == 'ROLE_ARTIST') {
                $profile = $userManager->newProfile($data);
                $profile->setUser($user);
                $profile->setActive(true);
                $validationErrors->addAll($validator->validate($profile));

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
            if (!$user->isFake()) {
                $userManager->confirmationForCreatedUser($user);
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
        $user = $userRepo->find($userId);
        if (is_null($user->getConfirmationToken())) {
            /** if not exist token - generate new token */
            $user->setConfirmationToken($userManager->generateToken());
        }
        $now = new \DateTime();
        $user->setCreatedAt($now);
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
                $mediaManager->removeFiles($user, $messageFiles);
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
