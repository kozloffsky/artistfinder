<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Media;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Form\MediaUploadType;
use Acted\LegalDocsBundle\Form\PerformanceType;
use Acted\LegalDocsBundle\Model\MediaManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PerformanceController extends Controller
{
    public function newAction(Request $request, Artist $artist)
    {
        $performance = new Performance();
        $performanceForm = $this->createForm(PerformanceType::class, $performance, ['method' => 'POST']);
        $performanceForm->handleRequest($request);

        if($performanceForm->isSubmitted() && $performanceForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $performance->setProfile($artist->getUser()->getProfile());
            $em->persist($performance);
            $em->flush();
            $serializer = $this->get('jms_serializer');
            return new JsonResponse(['status' => 'success', 'performance' => $serializer->toArray($performance)]);
        }

        return new JsonResponse($this->formErrorResponse($performanceForm));
    }

    public function editAction(Request $request, Performance $performance)
    {
        $mediaForm = $this->createForm(PerformanceType::class, $performance, ['method' => 'PATCH']);
        $mediaForm->handleRequest($request);

        if($mediaForm->isSubmitted() && $mediaForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($performance);


            $em->flush();
            return new JsonResponse(['status' => 'success']);
        }

        return new JsonResponse($this->formErrorResponse($mediaForm));
    }

    public function newMediaAction(Request $request, Performance $performance)
    {
        $serializer = $this->get('jms_serializer');
        $form = $this->createForm(MediaUploadType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $mediaManager = $this->get('app.media.manager');
            $media = new Media();
            $performance->addMedia($media);

            $validator = $this->get('validator');
            $validationErrors = $validator->validate($performance);

            if (count($validationErrors) > 0) {
                return new JsonResponse($serializer->toArray($validationErrors), 400);
            }

            if(!is_null($data['video'])) {
                if (strripos($data['video'], 'youtube.com') === false && strripos($data['video'], 'vimeo.com') === false ) {
                    return new JsonResponse([
                        'status' => 'error',
                        'message' => 'Added link should be from "youtube.com" or "vimeo.com"'
                    ],  400);
                }
                $media = $mediaManager->updateVideo($data['video'], $media);
            } elseif(!is_null($data['audio'])) {
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
                $media = $mediaManager->updatePhoto($file, $media);
            }

            $em->persist($media);
            $em->flush();

            return new JsonResponse(['status' => 'success', 'media' => $serializer->toArray($media)]);
        }

        return new JsonResponse($serializer->toArray($form->getErrors()));
    }
}
