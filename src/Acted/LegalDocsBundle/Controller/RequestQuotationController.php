<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Event;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Acted\LegalDocsBundle\Form\RequestQuotationPrepareType;

class RequestQuotationController extends Controller
{
    /**
     * Prepare quotations
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Prepare quotations",
     *  input="Acted\LegalDocsBundle\Form\RequestQuotationPrepareType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function prepareAction(Request $request)
    {
        //var_dump('!!!');exit;

        $serializer = $this->get('jms_serializer');

        $requestQuotationPrepareForm = $this->createForm(RequestQuotationPrepareType::class, null, ['method' => 'POST']);
        $requestQuotationPrepareForm->handleRequest($request);

        if ($requestQuotationPrepareForm->isSubmitted() && (!$requestQuotationPrepareForm->isValid())) {
            return new JsonResponse($serializer->toArray($requestQuotationPrepareForm->getErrors()), Response::HTTP_BAD_REQUEST);
        }



    }
}
