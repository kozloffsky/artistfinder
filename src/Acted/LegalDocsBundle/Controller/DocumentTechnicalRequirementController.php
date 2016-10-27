<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Form\DocumentTechnicalRequirementType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Acted\LegalDocsBundle\Entity\TechnicalRequirement;
use Acted\LegalDocsBundle\Entity\DocumentTechnicalRequirement;
use JMS\Serializer\SerializationContext;

class DocumentTechnicalRequirementController extends Controller
{
    public function uploadAction(Request $request)
    {
        //var_dump($this->get('kernel')->getRootDir());exit;
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();

        $documentTechnicalRequirementForm = $this->createForm(DocumentTechnicalRequirementType::class, null, ['method' => 'POST']);
        $documentTechnicalRequirementForm->handleRequest($request);

        if ($documentTechnicalRequirementForm->isSubmitted() && (!$documentTechnicalRequirementForm->isValid())) {
            return new JsonResponse($serializer->toArray($documentTechnicalRequirementForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $data = $documentTechnicalRequirementForm->getData();

        if (empty($data)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'There are not any data'
            ],  Response::HTTP_BAD_REQUEST);
        }

        if (empty($request->files->get('document_technical_requirement')) || empty($request->files->get('document_technical_requirement')['files'])) {
            return new JsonResponse(['errors' => array(
                'there are not any files'
            )], Response::HTTP_BAD_REQUEST);
        }

        $documents = $request->files->get('document_technical_requirement')['files'];
        $fileFormats = $this->container->getParameter('file_formats');
        $constraints = array('maxSize'=>'10M', 'mimeTypes' => $fileFormats);
        $uploadFiles = $this->get('file_uploader')->create($documents, $constraints);
        $response = [];

        if ($uploadFiles->upload()) {
            foreach ($uploadFiles->getDataFiles() as $fileData) {
                $documentTechnicalRequirement = new DocumentTechnicalRequirement();
                $documentTechnicalRequirement->setTechnicalRequirement($data->getTechnicalRequirement());
                $documentTechnicalRequirement->setName($fileData['name']);
                $documentTechnicalRequirement->setSize($fileData['size']);
                $documentTechnicalRequirement->setFile($fileData['relativeDirectory'] . '/' . $fileData['name']);
                $response[] = $documentTechnicalRequirement;
                $documentTechnicalRequirement->setUrl('//' . $_SERVER['HTTP_HOST'] . '/' . $fileData['relativeDirectory'] . '/' . $fileData['name']);

                $em->persist($documentTechnicalRequirement);
            }

            $em->flush();

            return new JsonResponse($serializer->toArray($response, SerializationContext::create()
                ->setGroups(['files'])), Response::HTTP_OK);
        }

        return new JsonResponse(['errors' => $serializer->toArray($uploadFiles->getErrors())], Response::HTTP_BAD_REQUEST);
    }

    public function removeAction(Request $request, DocumentTechnicalRequirement $documentTechnicalRequirement = null)
    {
        if (empty($documentTechnicalRequirement)) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'Document technical requirement is not found'
            ],  Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $path = $this->get('kernel')->getRootDir() . '/../web/' . '';

        $em->remove($documentTechnicalRequirement);
        $em->flush();

        $filePath = $this->get('kernel')->getRootDir() . '/../web/' . $documentTechnicalRequirement->getFile();
        if(file_exists($filePath)) {
            unlink($filePath);
        }

        return new JsonResponse(['status' => 'success']);
    }
}
