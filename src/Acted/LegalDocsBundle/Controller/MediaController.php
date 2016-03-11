<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Entity\Media;
use Acted\LegalDocsBundle\Form\MediaType;
use Acted\LegalDocsBundle\Form\MediaUploadType;
use Acted\LegalDocsBundle\Model\MediaManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            $serializer = $this->get('jms_serializer');
            $em->flush();
            return new JsonResponse(['status' => 'success', 'media' => $serializer->toArray($media)]);
        }

        return new JsonResponse($this->formErrorResponse($mediaForm));
    }

    public function editAction(Request $request, Media $media)
    {
        $serializer = $this->get('jms_serializer');
        $form = $this->createForm(MediaUploadType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $mediaManager = new MediaManager();

            if(!empty($data['video'])) {
                $media = $mediaManager->updateVideo($data['video'], $media);
            } elseif(!empty($data['audio'])) {
                $media = $mediaManager->updateAudio($data['audio'], $media);
            } else {
                /** @var UploadedFile $file */
                $file = $data['file'];
                $media = $mediaManager->updatePhoto($file, $media);
            }

            $em->persist($media);
            $em->flush();

            return new JsonResponse(['status' => 'success', 'media' => $serializer->toArray($media)]);
        }

        return new JsonResponse($serializer->toArray($form->getErrors()));
    }
}
