<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Form\UserType;
use Acted\LegalDocsBundle\HttpFoundation\File\Base64File;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $user = ($request->get('user'))
            ? $em->getRepository('ActedLegalDocsBundle:User')->findOneById($request->get('user')) : null;

        if ($request->request->has('user')) {
            $userRequest = $request->request->get('user');
            if(!empty($userRequest['avatar'])) {
                $file = new Base64File($userRequest['avatar'], 'image/png');
                $file = $file->move('images', $file->getBasename());
                $request->request->set('user', ['avatar' => $file]);
            }
            if(!empty($userRequest['background'])) {
                $file = new Base64File($userRequest['background'], 'image/png');
                $file = $file->move('images', $file->getBasename());
                $request->request->set('user', ['background' => $file]);
            }
        }

        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {
            $em->persist($user);
            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        $errors = [];
        foreach ($userForm->getErrors(true, true) as $formError) {
            $errors[] = $formError->getMessage();
        }
        $data = [];
        $data['status'] = 'error';
        $data['errors'] = $errors;
        return new JsonResponse($data);
    }
}
