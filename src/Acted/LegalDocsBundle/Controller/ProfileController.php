<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Offer;
use Acted\LegalDocsBundle\Form\ArtistType;
use Acted\LegalDocsBundle\Form\OfferType;
use Acted\LegalDocsBundle\Form\ProfileType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    public function showAction(Request $request, Artist $artist)
    {
        $em = $this->getDoctrine()->getManager();

        $categoriesRepo = $em->getRepository('ActedLegalDocsBundle:Category');
        $categories = $categoriesRepo->childrenHierarchy();

        //TODO: for debug only
        $user = ($request->get('user'))
            ? $em->getRepository('ActedLegalDocsBundle:User')->findOneById($request->get('user')) : null;

        $offers = $this->getOffers($artist, 1);
        $feedbacks = $this->getFeedbacks($artist, 1);

        return $this->render('ActedLegalDocsBundle:Profile:show.html.twig',
            compact('artist', 'user', 'offers', 'feedbacks', 'categories')
        );
    }

    public function editAction(Request $request, Artist $artist)
    {
        $artistForm = $this->createForm(ArtistType::class, $artist);
        $artistForm->handleRequest($request);
        $profileForm = $this->createForm(ProfileType::class, $artist->getUser()->getProfile());
        $profileForm->handleRequest($request);


        if($artistForm->isSubmitted() && $artistForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artist);
            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        if($profileForm->isSubmitted() && $profileForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artist->getUser()->getProfile());
            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        if($artistForm->isSubmitted()) {
            return new JsonResponse($this->formErrorResponse($artistForm));
        }

        return new JsonResponse($this->formErrorResponse($profileForm));
    }

    public function offersAction(Request $request, Artist $artist)
    {
        $offers = $this->getOffers($artist, $request->get('page', 1));
        return $this->render('@ActedLegalDocs/Profile/ordersSection.html.twig', compact('offers'));
    }

    public function offerEditAction(Request $request, Offer $offer)
    {
        $offerForm = $this->createForm(OfferType::class, $offer);
        $offerForm->handleRequest($request);

        if($offerForm->isSubmitted() && $offerForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer);
            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse($this->formErrorResponse($offerForm));
    }

    public function feedbacksAction(Request $request, Artist $artist)
    {
        $feedbacks = $this->getFeedbacks($artist,  $request->get('page', 1));
        return $this->render('@ActedLegalDocs/Profile/feedbacksSection.html.twig', compact('feedbacks'));
    }

    private function getOffers(Artist $artist, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        return $paginator->paginate(
            $em->getRepository('ActedLegalDocsBundle:Offer')->findByArtistQuery($artist),
            $page,
            $this->getParameter('per_page')
        );
    }

    private function getFeedbacks(Artist $artist, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        return $paginator->paginate(
            $em->getRepository('ActedLegalDocsBundle:ArtistRating')->findByArtistQuery($artist),
            $page,
            $this->getParameter('per_page')
        );
    }

    public function listAction()
    {
        $entities = $this->getDoctrine()->getManager()->getRepository('ActedLegalDocsBundle:Artist')->findAll();
        return $this->render('ActedLegalDocsBundle:Profile:list.html.twig', ['entities' => $entities]);
    }

}
