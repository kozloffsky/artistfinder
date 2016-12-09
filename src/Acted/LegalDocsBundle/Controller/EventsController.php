<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\ChatRoom;
use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Entity\EventOffer;
use Acted\LegalDocsBundle\Entity\RequestQuotation;
use Acted\LegalDocsBundle\Entity\EventArtist;
use Acted\LegalDocsBundle\Form\EventOfferType;
use Acted\LegalDocsBundle\Repository\EventRepository;
use Acted\LegalDocsBundle\Popo\EventOfferData;
use Doctrine\ORM\EntityManager;
use Acted\LegalDocsBundle\Form\ArtistEventCreateType;
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

            if (!$data->getPerformance()->isEmpty()) {
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
            }

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
        $events = $this->getEM()->getRepository('ActedLegalDocsBundle:Event')->getEventsByUserId($userId);
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

    /**
     * Get all messages for the event.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getMessagesAction(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $userId = $user->getId();
        $em = $this->getEM();
        /**
         * @var EventRepository $eventRepo
         */
        $eventRepo = $em->getRepository("ActedLegalDocsBundle:Event");
        /**
         * @var Event $event
         */
        $event = $eventRepo->find($request->get('event'));
        $filter = $request->get('filter');
        /**
         * @var ChatRoom $chatRoom
         */
        $chatRoom = $event->getChatRooms()->first();
        $chatRoomId = $chatRoom->getId();
        $messagesRepo = $em->getRepository('ActedLegalDocsBundle:Message');
        $messages = $messagesRepo->getAllEventMessages($userId, $chatRoomId, $filter);
        if ($user->getRoles()[0] == "ROLE_ARTIST") {
            $messages = $messagesRepo->getAllMessages($userId, $filter);
        }
        $context = SerializationContext::create()->setGroups(['all_messages']);
        $serializer = $this->get('jms_serializer');

        $messages = $serializer->toArray($messages, $context);
        $response = ['status' => 'success', 'messages' => $messages];

        return new JsonResponse($response);
    }

    /**
     * add artist to event
     *
     * @ApiDoc(
     *  resource=true,
     *  description="get events by client",
     *  input="Acted\LegalDocsBundle\Form\ArtistEventCreateType",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function addArtistToEventAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $em = $this->getDoctrine()->getManager();
        $eventRepo = $em->getRepository('ActedLegalDocsBundle:Event');
        $eventArtistRepo = $em->getRepository('ActedLegalDocsBundle:EventArtist');

        $form = $this->createForm(ArtistEventCreateType::class);
        $form->handleRequest($request);

        $em->getConnection()->beginTransaction();

        try {
            if ($form->isSubmitted() && (!$form->isValid())) {
                return new JsonResponse($serializer->toArray($form->getErrors()), Response::HTTP_BAD_REQUEST);
            }

            $data = $form->getData();
            if (empty($data)) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'There are not any data'
                ], Response::HTTP_BAD_REQUEST);
            }

            $event = $data['event'];
            $artist = $em->getRepository('ActedLegalDocsBundle:Artist')->findOneBySlug($data['slug']);
            $userArtist = $artist->getUser();

            if (empty($artist)) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'User not found'
                ], Response::HTTP_BAD_REQUEST);
            }

            $eventArtist = $eventArtistRepo->findOneBy(array('event' => $event, 'artist' => $artist));
            if (!empty($eventArtist)) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Artist already exists in event'
                ], Response::HTTP_BAD_REQUEST);
            }

            $eventOfferData = new EventOfferData();
            $eventOfferData->setName($event->getTitle());
            $eventOfferData->setPerformance($data['performance']);
            $eventOfferData->setComment($data['comment']);
            $eventOfferData->setEventTime($event->getTiming());
            $eventOfferData->setUser($userArtist);

            $eventOfferData->setType($event->getEventType());
            //$eventOfferData->setCountry();
            $eventOfferData->setCity($event->getCity());
            $eventOfferData->setLocation($event->getAddress());
            $eventOfferData->setVenueType($event->getVenueType());
            $eventOfferData->setNumberOfGuests($event->getNumberOfGuests());
            $eventOfferData->setAdditionalInfo($event->getComments());


            $eventManager = $this->get('app.event.manager');
            $chatManager = $this->get('app.chat.manager');

            /** Add Offer */
            $offer = $eventManager->createOffer($eventOfferData);
            $em->persist($offer);

            /** Add EventOffer */
            $eventOffer = $eventManager->createEventOffer($eventOfferData);
            $eventOffer->setOffer($offer);
            $eventOffer->setEvent($event);
            $eventOffer->setActsExtrasAccepted(false);
            $eventOffer->setTechnicalRequirementsAccepted(false);
            $eventOffer->setTimingAccepted(false);
            $eventOffer->setActsExtrasAccepted(false);
            $eventOffer->setDetailsAccepted(false);
            $em->persist($eventOffer);
            $em->flush();

            /*Add artist to event*/
            $eventArtist = new EventArtist();
            $eventArtist->setEvent($event);
            $eventArtist->setArtist($artist);
            $em->persist($eventArtist);

            /** Create ChatRoom */
            $chatManager->createChat($event, $userArtist, $eventOfferData, $offer);
            /** Notify Artist */
            $eventManager->createEventNotify($eventOfferData, $userArtist, $offer);
            $eventManager->newMessageNotify($eventOfferData, $userArtist);

            /*Create request*/
            $requestQuotation = new RequestQuotation();
            $requestQuotation->setEvent($event);
            $em->persist($requestQuotation);
            $em->flush();

            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();

            return new JsonResponse([
                'status' => 'error',
                'message' => 'Error connecting'
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(array(
            'status' => 'success',
        ), Response::HTTP_OK);
    }
}