<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Offer;
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

        $paginator = $this->get('knp_paginator');
        $offers = $paginator->paginate(
            $em->getRepository('ActedLegalDocsBundle:Offer')->findByArtistQuery($artist),
            $request->get('page'),
            3
        );


        return $this->render('ActedLegalDocsBundle:Profile:show.html.twig',
            compact('artist', 'user', 'offers')
        );
    }

    public function listAction()
    {
        $entities = $this->getDoctrine()->getManager()->getRepository('ActedLegalDocsBundle:Artist')->findAll();

        return $this->render('ActedLegalDocsBundle:Profile:list.html.twig', array('entities' => $entities));
    }

}
