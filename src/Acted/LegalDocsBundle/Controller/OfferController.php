<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\VarDumper\VarDumper;

class OfferController extends Controller
{

    public function indexAction(Request $request, Artist $artist)
    {
        $paginator = $this->get('knp_paginator');
        $em = $this->getDoctrine()->getManager();


        $offers = $paginator->paginate(
            $em->getRepository('ActedLegalDocsBundle:Offer')->findByArtistQuery($artist),
            $request->get('page'),
            $this->getParameter('per_page')
        );


        return $this->render('ActedLegalDocsBundle:Offer:index.html.twig', array(
            compact('offers')
        ));
    }

}
