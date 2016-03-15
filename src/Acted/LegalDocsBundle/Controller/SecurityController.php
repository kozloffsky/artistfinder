<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Form\RegisterType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        // will never be executed
    }

    public function registerAction(Request $request)
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);
        $serializer = $this->get('jms_serializer');

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if($data['role'] == 'ROLE_CLIENT') {

                $userManager = $this->get('app.user.manager');
                $em = $this->getDoctrine()->getManager();
                $validator = $this->get('validator');

                $user = $userManager->newUser($data['firstname'], $data['lastname'], $data['email'], $data['password'], $data['role']);

                $validationErrors = $validator->validate($user);
                if (count($validationErrors) == 0) {
                    $em->persist($user);
                    $em->flush();
                    $userManager->sendConfirmationEmailMessage($user);
                    return new JsonResponse(['status' => 'success', 'user' => $serializer->toArray($user)]);
                } else {
                    return new JsonResponse($serializer->toArray($validationErrors), 400);
                }
            }
        }

        return new JsonResponse($serializer->toArray($form->getErrors()), 400);
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

        $em->flush();

        return $this->render('@ActedLegalDocs/Security/confirmed.html.twig', compact('user'));
    }
}
