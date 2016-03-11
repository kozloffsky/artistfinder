<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Form\PerformanceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PerformanceController extends Controller
{
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
}
