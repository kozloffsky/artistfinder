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
            $mediaManager = $this->get('app.media.manager');

            if(!empty($data['video'])) {
                if (strripos($data['video'], 'youtube.com') === false && strripos($data['video'], 'vimeo.com') === false ) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Added link should be from "youtube.com" or "vimeo.com"'
                    ],  400);
                }
                $media = $mediaManager->updateVideo($data['video'], $media);
            } elseif(!empty($data['audio'])) {
                if (strripos($data['audio'], 'soundcloud.com') === false || strripos($data['audio'], 'iframe')) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Added link should be from "soundcloud.com" embed'
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
            $em->flush();

            return new JsonResponse(['status' => 'success', 'media' => $serializer->toArray($media)]);
        }

        return new JsonResponse($serializer->toArray($form->getErrors()));
    }

    public function deleteAction(Media $media)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($media);
        $em->flush();
        return new JsonResponse(['status' => 'success']);
    }
}
