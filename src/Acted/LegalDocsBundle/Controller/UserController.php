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

    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //TODO: for debug only
        $user = ($request->query->get('user'))
            ? $em->getRepository('ActedLegalDocsBundle:User')->findOneById($request->query->get('user')) :
            $em->getRepository('ActedLegalDocsBundle:User')->findAll()[0];


        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {
            $em->persist($user);
            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse($this->formErrorResponse($userForm));
    }
}