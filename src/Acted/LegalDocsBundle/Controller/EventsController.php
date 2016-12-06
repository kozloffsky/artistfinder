<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Entity\EventOffer;
use Acted\LegalDocsBundle\Entity\RequestQuotation;
use Acted\LegalDocsBundle\Entity\EventArtist;
use Acted\LegalDocsBundle\Form\EventOfferType;
use Doctrine\ORM\EntityManager;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

use JMS\Serializer\SerializationContext;

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

        if ($form->isSubmitted() && $form->isValid()) {
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
                $offers = $eventManager->getOfferByParams($data->getUser()->getId(), $event);
                if ($offers) {
                    return new JsonResponse(['error' => 'Offer for artist already exist'], 400);
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
            $eventOffer->setActsExtrasAccepted(false);
            $eventOffer->setTechnicalRequirementsAccepted(false);
            $eventOffer->setTimingAccepted(false);
            $eventOffer->setActsExtrasAccepted(false);
            $eventOffer->setDetailsAccepted(false);
            $validationErrors->addAll($validator->validate($eventOffer));
            $em->persist($eventOffer);

            if (count($validationErrors) > 0) {
                $errors = $serializer->toArray($validationErrors);
                $prettyErrors = [];
                foreach ($errors as $error) {
                    foreach ($error as $key => $value) {
                        $prettyErrors[$key] = $value;
                    }
                }
                return new JsonResponse($prettyErrors, 400);
            }
            $em->flush();
            $userArtist = $data->getPerformance()->first()->getProfile()->getUser();
            $artist = $userArtist->getArtist();

            /*Add artist to event*/
            $eventArtist = new EventArtist();
            $eventArtist->setEvent($event);
            $eventArtist->setArtist($artist);
            $em->persist($eventArtist);
            $em->flush();

            /** Create ChatRoom */
            $chatManager->createChat($event, $userArtist, $data, $offer);
            /** Notify Artist */
            $eventManager->createEventNotify($data, $userArtist, $offer);
            $eventManager->newMessageNotify($data, $userArtist);

            /*Create request*/
            $requestQuotation = new RequestQuotation();
            $requestQuotation->setEvent($event);
            $em->persist($requestQuotation);
            $em->flush();

            return new JsonResponse(['success' => 'Event successfully created!']);
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

    /**
     * @ApiDoc(
     *  description="Gets event by id",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function getEventByIdAction(Request $request)
    {
        $eventId = $request->get('id');

        $serializer = $this->get('jms_serializer');

        $eventOffer = $this->getEM()->getRepository('ActedLegalDocsBundle:EventOffer')->getEventOfferByEventId($eventId);

        if ($eventOffer) {
            return new JsonResponse($serializer->toArray($eventOffer[0], SerializationContext::create()->setGroups(['getEvent'])));
        } else {
            return new JsonResponse(['empty']);
        }
    }

    /**
     * Get artists in event
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get artists in event",
     *  input="Acted\LegalDocsBundle\Form\FeedbackRatingCreateType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param Event $event
     * @param integer $page
     * @param integer $size
     * @return JsonResponse
     */
    public function getEventArtistsAction(Request $request, Event $event, $page, $size)
    {
        $em = $this->getDoctrine()->getManager();
        $eventArtistRepo = $em->getRepository('ActedLegalDocsBundle:EventArtist');

        $eventArtists = $eventArtistRepo->getEventArtists($event, $page, $size);

        return new JsonResponse(array(
            'status' => 'success',
            'artists' => $eventArtists['artists']
        ), Response::HTTP_OK, array(
            'count' => $eventArtists['countRows']
        ));
    }

    /**
     * get events by client
     *
     * @ApiDoc(
     *  resource=true,
     *  description="get events by client",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @param User $user
     * @param integer $page
     * @param integer $size
     * @return JsonResponse
     */
    public function getClientEventsAction(Request $request, User $user, $page, $size)
    {
        $em = $this->getDoctrine()->getManager();
        $eventRepo = $em->getRepository('ActedLegalDocsBundle:Event');

        $clientEvents = $eventRepo->getClientEvents($user, $page, $size);

        return new JsonResponse(array(
            'status' => 'success',
            'events' => $clientEvents['events']
        ), Response::HTTP_OK, array(
            'count' => $clientEvents['countRows']
        ));
    }

    public function updateEventAction(Request $request)
    {
        $eventId = $request->get('event');
        $data = $request->get('data');

        /**
         * @var EntityManager $em
         */
        $em = $this->getEM();
        $repo = $em->getRepository('ActedLegalDocsBundle:Event');

        if (key_exists('venueType', $data)) {
            $venueRepo = $em->getRepository('ActedLegalDocsBundle:RefVenueType');
            $venue = $venueRepo->find($data['venueType']);

            if (!$venue) {
                $message = "No Venue was found";
                $response = ['status' => 'error', "message" => $message];
                return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $data['venueType'] = $venue;
        }
        /**
         * @var Event $event
         */
        $event = $repo->find($eventId);

        if ($event) {
            $validator = $this->get('validator');
            $event->setOptions($data);
            $errors = $validator->validate($event);

            if (count($errors) > 0) {
                //Debug. Can be removed.
                $response = ['status' => 'error', 'errors' => $errors];
                return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
            }

            $em->persist($event);
            $em->flush();

            $response = ['status' => 'success'];
            return new JsonResponse($response);
        }

        $message = "No Event was found";
        $response = ['status' => 'error', "message" => $message];
        return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    /**
     * Get Event data by id.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getEventDataByIdAction(Request $request)
    {
        $id = $request->get('event');

        $em = $this->getEM();
        $repo = $em->getRepository('ActedLegalDocsBundle:Event');
        $event = $repo->find($id);

        $serializer = $this->get("jms_serializer");
        $context = SerializationContext::create()->setGroups('getEvent');
        $event = $serializer->toArray($event, $context);

        $toResponse = ['status' => 'success', 'event' => $event];

        return new JsonResponse($toResponse);
    }

    /**
     * Show all possible venues.
     *
     * @return JsonResponse
     */
    public function showVenuesAction()
    {
        $venues = $this->getEM()->getRepository('ActedLegalDocsBundle:RefVenueType')->findAll();

        $serializer = $this->get('jms_serializer');

        $venues = $serializer->toArray($venues);

        return new JsonResponse(["status" => "success", "venues" => $venues]);
    }
}