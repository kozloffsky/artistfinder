<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Offer;
use Acted\LegalDocsBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\VarDumper\VarDumper;

class ProfileController extends Controller
{
    public function showAction(Request $request, Artist $artist)
    {
        $em = $this->getDoctrine()->getManager();

        //TODO: for debug only
        $user = ($request->get('user'))
            ? $em->getRepository('ActedLegalDocsBundle:User')->findOneById($request->get('user')) : null;

        $offers = $this->getOffers($artist, $request->get('page'));

        return $this->render('ActedLegalDocsBundle:Profile:show.html.twig',
            compact('artist', 'user', 'offers')
        );
    }

    public function offersAction(Request $request, Artist $artist)
    {
        $offers = $this->getOffers($artist, $request->get('page'));

        return $this->render('@ActedLegalDocs/Profile/ordersSection.html.twig',
            compact('offers')
        );
    }

    private function getOffers(Artist $artist, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        $page = max(1, intval($page));
        return $paginator->paginate(
            $em->getRepository('ActedLegalDocsBundle:Offer')->findByArtistQuery($artist),
            (int)$page,
            $this->getParameter('per_page')
        );
    }

    public function listAction()
    {
        $entities = $this->getDoctrine()->getManager()->getRepository('ActedLegalDocsBundle:Artist')->findAll();

        return $this->render('ActedLegalDocsBundle:Profile:list.html.twig', array('entities' => $entities));
    }

}
