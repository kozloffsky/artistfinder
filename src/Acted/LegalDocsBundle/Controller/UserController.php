<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Form\UserType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', ['name' => $name]);
    }

    public function editAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ActedLegalDocsBundle:Artist')->findOneBySlug($slug)->getUser();

        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {
            $data = $userForm->getData();

            if (!empty($data->getAvatar())) {
                $userManager = $this->get('app.user.manager');
                $user = $userManager->updateAvatar($data->getAvatar(), $user, $request);
            }

            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse($this->formErrorResponse($userForm));
    }
}
