<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Media;
use Acted\LegalDocsBundle\Entity\Offer;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Form\ArtistType;
use Acted\LegalDocsBundle\Form\MediaUploadType;
use Acted\LegalDocsBundle\Form\OfferType;
use Acted\LegalDocsBundle\Form\ProfileType;
use Acted\LegalDocsBundle\Model\MediaManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProfileController extends Controller
{
    public function showAction(Request $request, Artist $artist)
    {
        $em = $this->getDoctrine()->getManager();

        $categoriesRepo = $em->getRepository('ActedLegalDocsBundle:Category');
        $categories = $categoriesRepo->childrenHierarchy();

        $user = $this->getUser();

        $performances = $this->getPerformances($artist, $request->get('page', 1));
        $feedbacks = $this->getFeedbacks($artist, 1);

        return $this->render('ActedLegalDocsBundle:Profile:show.html.twig',
            compact('artist', 'user', 'performances', 'feedbacks', 'categories')
        );
    }

    public function editProfileAction(Request $request, Artist $artist)
    {
        $em = $this->getDoctrine()->getManager();

        $categoriesRepo = $em->getRepository('ActedLegalDocsBundle:Category');
        $categories = $categoriesRepo->childrenHierarchy();

        $user = $this->getUser();

        $performances = $this->getPerformances($artist, $request->get('page', 1));
        $feedbacks = $this->getFeedbacks($artist, 1);

        return $this->render('ActedLegalDocsBundle:Profile:profile_edit.html.twig',
            compact('artist', 'user', 'performances', 'feedbacks', 'categories')
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

    public function performancesAction(Request $request, Artist $artist)
    {
        $performances = $this->getPerformances($artist, $request->get('page', 1));
        return $this->render('@ActedLegalDocs/Profile/ordersSection.html.twig', compact('performances', 'artist'));
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
        return $this->render('@ActedLegalDocs/Profile/feedbacksSection.html.twig', compact('feedbacks', 'artist'));
    }

    /**
     * @ParamConverter("artist", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("media", options={"mapping": {"id": "id"}})
     */
    public function addMediaAction(Artist $artist, Media $media)
    {
        $profile = $artist->getUser()->getProfile();

        if(!$profile->getMedia()->contains($media)) {
            $em = $this->getDoctrine()->getManager();
            $profile->addMedia($media);
            $em->flush();
        }

        return new JsonResponse(['status' => 'success']);
    }

    /**
     * @ParamConverter("artist", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("performance", options={"mapping": {"id": "id"}})
     */
    public function deletePerformanceAction(Artist $artist, Performance $performance)
    {
        if($artist->getUser()->getProfile()->getPerformances()->contains($performance)){
            $em = $this->getDoctrine()->getManager();
            $em->remove($performance);
            $em->flush();
        }

        return new JsonResponse(['status' => 'success']);
    }

    public function newMediaAction(Request $request, Artist $artist)
    {
        $serializer = $this->get('jms_serializer');
        $form = $this->createForm(MediaUploadType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $mediaManager = $this->get('app.media.manager');
            $media = new Media();

            if(!is_null($data['video'])) {
                if (strripos($data['video'], 'youtube.com') === false && strripos($data['video'], 'vimeo.com') === false
                    &&  strripos($data['video'], 'youtu.be') === false ) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Added link should be from youtube.com or vimeo.com'
                    ],  400);
                }
                $media = $mediaManager->updateVideo($data['video'], $media);
            } elseif(!is_null($data['audio'])) {
                if (strripos($data['audio'], 'soundcloud.com') === false || strripos($data['audio'], 'iframe') === false) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Added link should be from soundcloud.com embed'
                    ],  400);
                }
                $media = $mediaManager->updateAudio($data['audio'], $media);
            } else {
                /** @var UploadedFile $file */
                $file = $data['file'];
                if (!in_array($file->getExtension(), ['png', 'jpg', 'jpeg'])) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'You should upload only png or jpg images'
                    ],  400);
                }
                $media = $mediaManager->updatePhoto($file, $media, $request);
            }

            $em->persist($media);
            $artist->getUser()->getProfile()->addMedia($media);

            $em->flush();

            return new JsonResponse(['status' => 'success', 'media' => $serializer->toArray($media)]);
        }

        return new JsonResponse($serializer->toArray($form->getErrors()));
    }

    /**
     * @ParamConverter("artist", options={"mapping": {"slug": "slug"}})
     * @ParamConverter("media", options={"mapping": {"id": "id"}})
     */
    public function deleteMediaAction(Artist $artist, Media $media)
    {
        $profile = $artist->getUser()->getProfile();

        if($profile->getMedia()->contains($media)) {
            $em = $this->getDoctrine()->getManager();
            $profile->removeMedia($media);
            $em->remove($media);
            $em->flush();
        }

        return new JsonResponse(['status' => 'success']);
    }

    private function getPerformances(Artist $artist, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
        return $paginator->paginate(
            $em->getRepository('ActedLegalDocsBundle:Performance')->findByArtistQuery($artist),
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
