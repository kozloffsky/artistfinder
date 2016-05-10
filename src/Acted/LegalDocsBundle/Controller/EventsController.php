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
            $em = $this->getDoctrine()->getManager();
            $validator = $this->get('validator');
            $data = $form->getData();
            $eventManager = $this->get('app.event.manager');

            if (!$data->getEvent()) {
                $event = $eventManager->createEvent($data);
                $validationErrors = $validator->validate($event);
                $em->persist($event);
            } else {
                $event = $data->getEvent();
            }

            var_dump(uniqid());die;

            $offer = $eventManager->createOffer($data);
            $validationErrors->addAll($validator->validate($offer));
            $em->persist($offer);

            $eventOffer = $eventManager->createEventOffer($data);
            $eventOffer->setOffer($offer);
            $eventOffer->setEvent($event);
            $validationErrors->addAll($validator->validate($eventOffer));
            $em->persist($eventOffer);


            if (count($validationErrors) > 0) {
                $errors = $serializer->toArray($validationErrors);
                $prettyErrors = [];
                foreach($errors as $error) {
                    foreach($error as $key=>$value) {
                        $prettyErrors[$key] = $value;
                    }
                }
                return new JsonResponse($prettyErrors, 400);
            }

            $em->flush();
            $eventManager->sendEmailMessage();
            return new JsonResponse($serializer->toArray($event));
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

    /**
     * Get events by user id
     * @Rest\View(serializerGroups={"getEvent"})
     * @ApiDoc(
     *  description="Get list events by userID",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     *
     * @param Request $request
     * @return array
     */
    public function getEventsByUserIdAction(Request $request)
    {
        $userId = $request->query->get('user');
        $events = $this->getEM()->getRepository('ActedLegalDocsBundle:EventOffer')->getEventsByUserId($userId);

        return ['events' => $events];
    }

    private function getEM()
    {
        return $this->getDoctrine()->getManager();
    }

}