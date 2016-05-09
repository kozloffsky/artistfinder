<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Form\EventType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class EventsController extends Controller
{

    /**
     * Create event
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Add new event",
     *  input="Acted\LegalDocsBundle\Form\EventType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function createEventAction(Request $request)
    {
        $form = $this->createForm(EventType::class);
        $form->handleRequest($request);
        $serializer = $this->get('jms_serializer');

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            var_dump($data);die;

        }

        return new JsonResponse($this->get('app.form_errors_serializer')->serializeFormErrors($form, false), 400);
    }

    /**
     * Events type list
     * @Rest\View
     * @ApiDoc(
     *  description="Get list events type",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     */
    public function getListEventsTypeAction()
    {
        $eventsType = $this->getEM()->getRepository('ActedLegalDocsBundle:RefEventType')->findAll();

        return ['eventsType' => $eventsType];

    }

    private function getEM()
    {
        return $this->getDoctrine()->getManager();
    }

}