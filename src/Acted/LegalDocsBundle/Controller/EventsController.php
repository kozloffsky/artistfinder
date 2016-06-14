<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\EventOffer;
use Acted\LegalDocsBundle\Form\EventOfferType;
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
     *  input="Acted\LegalDocsBundle\Form\EventOfferType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function addEventAction(Request $request)
    {
        $form = $this->createForm(EventOfferType::class);
        $form->handleRequest($request);
        $serializer = $this->get('jms_serializer');

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getEM();
            $validator = $this->get('validator');
            $data = $form->getData();

            $eventManager = $this->get('app.event.manager');
            $chatManager = $this->get('app.chat.manager');

            /** Add or get Event */
            if (!$data->getEvent()) {
                $event = $eventManager->createEvent($data);
                $validationErrors = $validator->validate($event);
                $em->persist($event);
            } else {
                $event = $data->getEvent();
                $offers = $eventManager->getPerformancesByParams($data->getUser()->getId(), $data->getPerformanceIds());
                if ($offers) {
                    return new JsonResponse($serializer->toArray($offers));
                }
            }

            /** Add Offer */
            $offer = $eventManager->createOffer($data);
            if (!isset($validationErrors)) {
                $validationErrors = $validator->validate($offer);
            } else {
                $validationErrors->addAll($validator->validate($offer));
            }
            $em->persist($offer);

            /** Add EventOffer */
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
            $artist = $data->getPerformance()->first()->getProfile()->getUser();

            /** Create ChatRoom */
            $chatManager->createChat($event, $artist, $data, $offer);
            /** Notify Artist */
            $eventManager->createEventNotify($data, $artist, $offer);
            $eventManager->newMessageNotify($data, $artist);

            return new JsonResponse(['success'=>'Event successfully created!']);
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
     * Venue type list
     * @Rest\View
     * @ApiDoc(
     *  description="Get list venue type",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     */
    public function getListVenueTypeAction()
    {
        $eventsType = $this->getEM()->getRepository('ActedLegalDocsBundle:RefVenueType')->findAll();

        return ['venueType' => $eventsType];

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
        $artists = $this->getEM()->getRepository('ActedLegalDocsBundle:EventOffer')->getArtists($userId);
        $result = [];
        foreach ($artists as $artist) {
            $result[$artist['event_id']][] = $artist['user_slug'];
        }

        return ['events' => $events, 'artists' => $result];
    }

    /**
     * Reject offer by offerId
     * @Rest\View
     * @ApiDoc(
     *  description="Reject offer by offerId",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when not exist offer",
     *     }
     * )
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changeStatusToRejectAction(Request $request)
    {
        $offerId = $request->get('id');
        $type = $request->query->get('type');
        $eventOffer = $this->getEM()->getRepository('ActedLegalDocsBundle:EventOffer')->findOneByOffer($offerId);
        if ($eventOffer) {
            $this->get('app.event.manager')->changeStatusOffer($eventOffer, EventOffer::EVENT_OFFER_STATUS_REJECT);
            if ($type === 'no_email') {
                return new JsonResponse(['success' => 'Success reject!']);
            }
            $this->addFlash('success', 'You Reject offer');

            return $this->redirectToRoute('acted_legal_docs_homepage');
        }
        $this->addFlash('error', 'not exist offer!');

        return $this->redirectToRoute('acted_legal_docs_homepage');
    }


    /**
     * @ApiDoc(
     *  description="Check exist offer by UserId for performance Ids",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function checkExistOfferAction(Request $request)
    {
        $performances = $request->get('performances');
        $userId = $request->get('userId');
        $eventManager = $this->get('app.event.manager');
        $serializer = $this->get('jms_serializer');
        $offers = $eventManager->getPerformancesByParams($userId, $performances);

        if ($offers) {
            return new JsonResponse($serializer->toArray($offers));
        } else {
            return new JsonResponse(['empty']);
        }
    }
}