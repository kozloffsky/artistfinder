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

        $user->setConfirmationToken(null);
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

            if ($user->isPasswordRequestNonExpired($this->getParameter('resetting.token_ttl'))) {
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

        if (!$user->isPasswordRequestNonExpired($this->getParameter('resetting.token_ttl'))) {
            return $this->redirect($this->generateUrl('security_resetting_request'));
        }

        $form = $this->createForm(ResettingFormType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $userManager = $this->get('app.user.manager');

            $user->setConfirmationToken(null);
            $user->setPasswordRequestedAt(null);
            $user = $userManager->updatePassword($user, $data['password']);
            $user->setActive(true);

            $em->flush();

            return new JsonResponse(['asdasd']);
        }


        return $this->render('@ActedLegalDocs/Security/changePassword.html.twig', [
           'form' => $form->createView(),
            'currentToken' => $token
        ]);
    }
}
