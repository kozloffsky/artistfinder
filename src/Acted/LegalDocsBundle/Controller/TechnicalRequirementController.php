<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Form\TechnicalRequirementType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Acted\LegalDocsBundle\Entity\TechnicalRequirement;
use Acted\LegalDocsBundle\Entity\Artist;
use JMS\Serializer\SerializationContext;

class TechnicalRequirementController extends Controller
{
    public function createAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $technicalRequirementForm = $this->createForm(TechnicalRequirementType::class, null, ['method' => 'POST']);
        $technicalRequirementForm->handleRequest($request);

        if ($technicalRequirementForm->isSubmitted() && (!$technicalRequirementForm->isValid())) {
            return new JsonResponse($serializer->toArray($technicalRequirementForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $technicalRequirement = new TechnicalRequirement();

        $data = $technicalRequirementForm->getData();

        if (empty($data)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'There are not any data'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $artist = $data->getArtist();
        $title = $data->getTitle();
        $description = $data->getDescription();

        $technicalRequirement->setArtist($artist);
        $technicalRequirement->setTitle($title);
        $technicalRequirement->setDescription($description);

        $em->persist($technicalRequirement);
        $em->flush();

        $technicalRequirementRepo = $em->getRepository('ActedLegalDocsBundle:TechnicalRequirement');

        $createdTechnicalRequirement = $technicalRequirementRepo->getFullTechnicalRequirementById($technicalRequirement->getId());
        if (!empty($createdTechnicalRequirement)) {
            $createdTechnicalRequirement = $createdTechnicalRequirement[0];
        }

        return new JsonResponse(['status' => 'success', 'technicalRequirement' => $createdTechnicalRequirement]);
    }

    public function editAction(Request $request, TechnicalRequirement $technicalRequirement)
    {
        $technicalRequirementForm = $this->createForm(TechnicalRequirementType::class, $technicalRequirement, ['method' => 'PUT']);
        $technicalRequirementForm->handleRequest($request);

        $serializer = $this->get('jms_serializer');

        if ($technicalRequirementForm->isSubmitted() && (!$technicalRequirementForm->isValid())) {
            return new JsonResponse($serializer->toArray($technicalRequirementForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($technicalRequirement);

        $em->flush();
        return new JsonResponse(['status' => 'success']);
    }

    public function removeAction(Request $request, TechnicalRequirement $technicalRequirement = null)
    {
        if (empty($technicalRequirement)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Technical requirement is not found'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $documentTechnicalRequirement = $this->getDoctrine()
            ->getRepository('ActedLegalDocsBundle:DocumentTechnicalRequirement');

        $documents = $documentTechnicalRequirement->getDocumentsByTRId($technicalRequirement->getId());

        foreach ($documents as $document) {
            $filePath = $this->get('kernel')->getRootDir() . '/../web/' . $document['file'];

            if(file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $em->remove($technicalRequirement);
        $em->flush();

        return new JsonResponse(['status' => 'success']);
    }

    public function getByArtistAction(Request $request, Artist $artist = null)
    {
        if (empty($artist)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Artist is not found'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $serializer = $this->get('jms_serializer');

        $repository = $this->getDoctrine()
            ->getRepository('ActedLegalDocsBundle:TechnicalRequirement');

        $technicalRequirementIds = $repository->getTechnicalRequirementIdsByArtistId($artist->getId());
        $technicalRequirements = $repository->getFullTechnicalRequirementsByIds($technicalRequirementIds);

       return new JsonResponse(array('technicalRequirements' => $technicalRequirements), Response::HTTP_OK);
    }

    public function getDocumentAction($documentId){
        $this->denyAccessUnlessGranted(array('ROLE_CLIENT','ROLE_ARTIST'));
        $uploader = $this->get('file_uploader');

        $response = new BinaryFileResponse($uploader->getUploadRootDir() . '/'
            .$this->getEM()
                ->getRepository('ActedLegalDocsBundle:DocumentTechnicalRequirement')
                ->getDocumentFile($documentId));
        return $response;
    }
}
