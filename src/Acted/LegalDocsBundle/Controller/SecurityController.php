<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Form\RegisterType;
use Acted\LegalDocsBundle\Form\RequestResettingFormType;
use Acted\LegalDocsBundle\Form\ResettingFormType;
use Acted\LegalDocsBundle\Popo\RegisterUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render('@ActedLegalDocs/Security/login.html.twig', [
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
        ]);
    }

    public function loginCheckAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }

    /**
     * Registration
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Registration",
     *  input="Acted\LegalDocsBundle\Form\RegisterType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     */
    public function registerAction(Request $request)
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

            $em->persist($user);

            if ($data->getRole() == 'ROLE_ARTIST') {
                $profile = $userManager->newProfile($data);
                $profile->setUser($user);
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
                    $data->getCityLng()
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
                //todo: refactor
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
            $userManager->sendConfirmationEmailMessage($user);
            return new JsonResponse($serializer->toArray($user));
        }

        return new JsonResponse($this->get('app.form_errors_serializer')->serializeFormErrors($form, false), 400);
    }

    /**
     * Email checking
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Check unique email",
     *  requirements={
     *      {
     *          "name"="email",
     *          "dataType"="email",
     *          "description"="email to check"
     *      }
     *  },
     * )
     */
    public function isEmailExistsAction($email)
    {
        $user = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ActedLegalDocsBundle:User')
            ->findOneByEmail($email);

        $data = [];
        $data['is_email_exists'] = (bool)$user;
        if ($user) {
            $data['message'] = 'User with this email already exists';
        }


        return new JsonResponse($data);
    }

    public function confirmAction($token)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository('ActedLegalDocsBundle:User')->findOneByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        if ($userCreated = $user->getCreatedAt()) {
            $now = new \DateTime();
            $activatePeriod = $this->container->getParameter('confirmation_period');
            $period = strtotime($userCreated->format('Y-m-d H:i:s')) + $activatePeriod;
            if ($period < strtotime($now->format('Y-m-d H:i:s'))) {
                $this->get('session')->getFlashBag()->set('error', 'Confirmation time left!');

                return $this->redirect($this->generateUrl('acted_legal_docs_homepage'));
            }
        }

        $user->setConfirmationToken(null);
        $user->setCreatedAt(null);
        $user->setPasswordRequestedAt(null);
        $user->setActive(true);

        $this->get('session')->getFlashBag()->set('confirm', 'Your account is now activated');

        $em->flush();

        return $this->redirect($this->generateUrl('acted_legal_docs_homepage'));
    }

    /**
     * Resent password action
     * @param Request $request
     * @return JsonResponse
     */
    public function sendResetPasswordAction(Request $request)
    {
        $form = $this->createForm(RequestResettingFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            /** @var User $user */
            $user = $em->getRepository('ActedLegalDocsBundle:User')->findOneByEmail($data['email']);

            if (null === $user) {
                return new JsonResponse(['error' => 'User with email '. $data['email'] . ' not exist.']);
            }

            if ($user->isPasswordRequestNonExpired($this->getParameter('resetting.token_ttl'), $this->getParameter('confirmation_period_resend'))) {
                return new JsonResponse(['error' => 'Message has been already sent to your email.']);
            }

            $userManager = $this->get('app.user.manager');

            $user->setConfirmationToken($userManager->generateToken());
            $user->setPasswordRequestedAt(new \DateTime());
            $em->flush();

            $userManager->sendResettingEmailMessage($user);
            return new JsonResponse(['success' => 'Email send to your email.']);
        }

        return new JsonResponse(['error' => 'Email not exist.']);
    }

    public function resetAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository('ActedLegalDocsBundle:User')->findOneByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        if (!$user->isPasswordRequestNonExpired($this->getParameter('resetting.token_ttl'), $this->getParameter('confirmation_period_resend')
        )) {
            return $this->redirect($this->generateUrl('security_resetting_request'));
        }

        $form = $this->createForm(ResettingFormType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $userManager = $this->get('app.user.manager');

            $user->setConfirmationToken(null);
            $user->setPasswordRequestedAt(null);
            $user->setConfirmationPeriod(null);
            $user = $userManager->updatePassword($user, $data['password']);
            $user->setActive(true);

            $em->flush();

            return new JsonResponse(['ok']);
        }

        return $this->render('@ActedLegalDocs/Security/changePassword.html.twig', [
           'form' => $form->createView(),
            'currentToken' => $token
        ]);
    }

    public function resendConfirmationTokenAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $em->getRepository('ActedLegalDocsBundle:User')->findOneByConfirmationToken($token);

        if (null === $user) {
            return $this->redirect($this->generateUrl('acted_legal_docs_homepage'));
        }

        if ($this->checkPeriodAuth($user)) {
            return $this->redirect($this->generateUrl('acted_legal_docs_homepage'));
        }

        $form = $this->createForm(ResettingFormType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $userManager = $this->get('app.user.manager');

            $user->setConfirmationToken(null);
            $user->setPasswordRequestedAt(null);
            $user->setConfirmationPeriod(null);
            $user->setTempPassword(null);
            $user = $userManager->updatePassword($user, $data['password']);
            $user->setActive(true);

            $em->flush();

            return new JsonResponse(['ok']);
        }

        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();

        return $this->render('@ActedLegalDocs/Security/resendToken.html.twig', [
            'form' => $form->createView(),
            'currentToken' => $token,
            'categories' => $categories
        ]);
    }

    /**
     * Check expired time
     * @param $user
     * @return bool
     */
    private function checkPeriodAuth($user)
    {
        $now = new \DateTime();

        if ( !$user->getActive() && $user->getTempPassword()) {
            if ($passwordRequestedAt = $user->getPasswordRequestedAt()) {
                $activatePeriodResend = $this->getParameter('confirmation_period_resend');
                $periodResend = strtotime($passwordRequestedAt->format('Y-m-d H:i:s')) + $activatePeriodResend;
                if ($periodResend < strtotime($now->format('Y-m-d H:i:s'))) {
                    return true;
                } else {
                    return false;
                }
            }

            if ($userCreated = $user->getCreatedAt()) {
                $activatePeriod = $this->getParameter('confirmation_period');
                $period = strtotime($userCreated->format('Y-m-d H:i:s')) + $activatePeriod;
                if ($period < strtotime($now->format('Y-m-d H:i:s'))) {
                    return true;
                }
            }
        }

        return false;
    }

    public function passwordRecoveryAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();

        return $this->render('@ActedLegalDocs/Security/passwordRecovery.html.twig', compact('categories'));
    }
}
