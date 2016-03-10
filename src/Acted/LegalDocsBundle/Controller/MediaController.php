<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Entity\Media;
use Acted\LegalDocsBundle\Form\MediaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends Controller
{

    public function createAction(Request $request)
    {
        $media = new Media();
        $mediaForm = $this->createForm(MediaType::class, $media);
        $mediaForm->handleRequest($request);

        if($mediaForm->isSubmitted() && $mediaForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);

            foreach($media->getPerformances() as $performance) {
                $performance->addMedia($media);
            }

            $em->flush();
            return new JsonResponse(['status' => 'success', 'id' => $media->getId()]);
        }

        return new JsonResponse($this->formErrorResponse($mediaForm));
    }

    public function editAction(Request $request, Media $media)
    {
        $mediaForm = $this->createForm(MediaType::class, $media, ['method' => 'PATCH']);
        $mediaForm->handleRequest($request);

        if($mediaForm->isSubmitted() && $mediaForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($media);


            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse($this->formErrorResponse($mediaForm));
    }
}
