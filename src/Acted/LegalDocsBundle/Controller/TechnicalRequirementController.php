<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Form\TechnicalRequirementType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Acted\LegalDocsBundle\Entity\TechnicalRequirement;
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
        //$userManager = $this->get('app.user.manager');

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

    public function removeAction(Request $request, TechnicalRequirement $technicalRequirement)
    {
        $em = $this->getDoctrine()->getManager();

        //$technicalRequirementRepo = $em->getRepository('ActedLegalDocsBundle:TechnicalRequirement');
        $em->remove($technicalRequirement);
        $em->flush();

        return new JsonResponse(['status' => 'success']);
    }

    //add removing TR
    //add uploading documents
    //add removing uploaded document
}
