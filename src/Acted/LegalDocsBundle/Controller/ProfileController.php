<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileController extends Controller
{
    public function showAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        //TODO: for debug only
        $user = ($request->get('user'))
            ? $em->getRepository('ActedLegalDocsBundle:User')->findOneById($request->get('user')) : null;


        /** @var Artist $artist */
        $artist = $em->getRepository('ActedLegalDocsBundle:Artist')->findOneBySlug($slug);

        if(!$artist) {
            throw new NotFoundHttpException();
        }

        return $this->render('ActedLegalDocsBundle:Profile:show.html.twig',
            compact('artist', 'user')
        );
    }

    public function listAction()
    {
        $entities = $this->getDoctrine()->getManager()->getRepository('ActedLegalDocsBundle:Artist')->findAll();

        return $this->render('ActedLegalDocsBundle:Profile:list.html.twig', array('entities' => $entities));
    }

}
