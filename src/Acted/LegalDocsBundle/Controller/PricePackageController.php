<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Form\PricePackageType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PricePackageController extends Controller
{
    public function editAction(Request $request, Performance $performance)
    {
        $serializer = $this->get('jms_serializer');
        $pricePackageFrom = $this->createForm(PricePackageType::class, $performance, ['method' => 'PATCH']);
        $pricePackageFrom->handleRequest($request);

        if ($pricePackageFrom->isSubmitted() && (!$pricePackageFrom->isValid())) {
            return new JsonResponse($serializer->toArray($pricePackageFrom->getErrors()), Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        $em->persist($performance);
        $em->flush();

        return new JsonResponse($this->formErrorResponse($pricePackageFrom));
    }
}
