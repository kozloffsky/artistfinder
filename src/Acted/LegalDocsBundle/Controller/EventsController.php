<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\ChatRoom;
use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Order;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Entity\EventOffer;
use Acted\LegalDocsBundle\Entity\RequestQuotation;
use Acted\LegalDocsBundle\Entity\EventArtist;
use Acted\LegalDocsBundle\Form\EventOfferType;
use Acted\LegalDocsBundle\Model\EventsManager;
use Acted\LegalDocsBundle\Model\OrderManager;
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
use JMS\DiExtraBundle\Annotation as DI;
use Acted\LegalDocsBundle\Form\LocationType;

use JMS\Serializer\SerializationContext;
use Symfony\Component\Validator\Constraints\NotBlank;

class EventsController extends Controller
{

    /**
     * @DI\Inject("acted_legal_docs.model.order_manager")
     * @var OrderManager
     */
    private $orderManager;

    /**
     * @DI\Inject("doctrine.orm.entity_manager")
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @DI\Inject("app.event.manager")
     * @var EventsManager
     */
    private $eventManager;

    /**
     * @DI\Inject("app.chat.manager")
     * @var EventsManager
     */
    private $chatManager;

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

        $this->entityManager->getConnection()->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);

        try {
            if ($form->isSubmitted() && $form->isValid()) {
                $validator = $this->get('validator');
                $data = $form->getData();

                /** Add or get Event */
                $event = $this->eventManager->createEvent($data);
                //TODO: if there are errors then return error response
                $validationErrors = $validator->validate($event);
                $this->entityManager->persist($event);

                if (!$data->getPerformance()->isEmpty()) {
                    $data->setUser($this->getUser());
                    /** Add Offer */
                    $performances = $data->getPerformance();
                    $userArtist = $data->getPerformance()->first()->getProfile()->getUser();
                    $artist = $userArtist->getArtist();
                    /** Create ChatRoom */
                    $chat = $this->chatManager->createChat($event, $userArtist, $data);
                    /** Notify Artist */
                    $this->eventManager->newMessageNotify($data, $userArtist);

                    $order = $this->orderManager->createOrder($event, $artist, $event->getUser()->getClient(), $performances, $chat);
                    $this->entityManager->flush();

                    $this->eventManager->createEventNotify($data, $userArtist, $order);
                }

                $this->entityManager->flush();
                $this->entityManager->getConnection()->commit();

                return new JsonResponse(['success' => 'Event successfully created!']);
            }
        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollback();

            return new JsonResponse([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);

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
            'status'  => 'success',
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
        $validator = $this->get('validator');

        /**
         * @var Event $event
         */
        $event = $repo->find($eventId);
        if (key_exists('location', $data)) {
            $constraint = new NotBlank();
            $location = $data['location'];
            foreach ($location as $item) {
                $error = $validator->validate($item, $constraint);
                if (0 !== count($error)) {
                    $message = 'Location error';
                    $response = ['status' => 'error', "message" => $message];

                    return new JsonResponse($response, Response::HTTP_UNPROCESSABLE_ENTITY);
                }
            }
            $country = $em->getRepository('ActedLegalDocsBundle:RefCountry')->findOneBy(array(
                'name' => $location['country']
            ));
            $refRegionRepo = $em->getRepository('ActedLegalDocsBundle:RefRegion');
            $regionId = $refRegionRepo->createRegion(
                $location['region_name'],
                $country,
                $location['region_lat'],
                $location['region_lng']
            );

            $region = $em->getRepository('ActedLegalDocsBundle:RefRegion')->findOneBy(array(
                'id' => $regionId
            ));

            $refCityRepo = $em->getRepository('ActedLegalDocsBundle:RefCity');
            $cityId = $refCityRepo->createCity(
                $location['city'],
                $region,
                $location['city_lat'],
                $location['city_lng'],
                $location['place_id']
            );

            $city = $em->getRepository('ActedLegalDocsBundle:RefCity')->findOneBy(array(
                'id' => $cityId
            ));
//
            $data = ['address' => $data['address'], 'cityId'=> $city->getId()];
        }
        if ($event) {
            $event->setOptions($data);
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

        if (empty($user)) {
            return new JsonResponse([
                'status'  => 'error',
                'message' => 'User is not authorized'
            ], Response::HTTP_UNAUTHORIZED);
        }

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
        $orderManager = $this->get('acted_legal_docs.model.order_manager');
        $orders = $orderManager->getOrdersForEvent($event);
        $messagesRepo = $em->getRepository('ActedLegalDocsBundle:Message');
        $filter = $request->get('filter');
        $messages = [];
        foreach ($orders as $order) {
            /**
             * @var Order $order
             */
            $chatRoomId = $order->getChat()->getId();
            $message = $messagesRepo->getChatRoomMessage($userId, $chatRoomId, $filter);
            if (count($message)) {
                $messages[] = $message[0];
            }
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
        $eventArtistRepo = $this->entityManager->getRepository('ActedLegalDocsBundle:EventArtist');

        $form = $this->createForm(ArtistEventCreateType::class);
        $form->handleRequest($request);

        $this->entityManager->getConnection()->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);

        try {
            if ($form->isSubmitted() && (!$form->isValid())) {
                return new JsonResponse($serializer->toArray($form->getErrors()), Response::HTTP_BAD_REQUEST);
            }

            $data = $form->getData();
            if (empty($data)) {
                return new JsonResponse([
                    'status'  => 'error',
                    'message' => 'There are not any data'
                ], Response::HTTP_BAD_REQUEST);
            }

            $performances = $data['performance'];

            $event = $data['event'];
            //TODO: find by id may be?
            $artist = $this->entityManager->getRepository('ActedLegalDocsBundle:Artist')->findOneBySlug($data['slug']);
            $userArtist = $artist->getUser();

            if (empty($artist)) {
                return new JsonResponse([
                    'status'  => 'error',
                    'message' => 'User not found'
                ], Response::HTTP_BAD_REQUEST);
            }

            /*$eventArtist = $eventArtistRepo->findOneBy(array('event' => $event, 'artist' => $artist));
            if (!empty($eventArtist)) {
                return new JsonResponse([
                    'status' => 'error',
                    'message' => 'Artist already exists in event'
                ], Response::HTTP_BAD_REQUEST);
            }*/

            $eventOfferData = new EventOfferData();
            $eventOfferData->setName($event->getTitle());
            $eventOfferData->setPerformance($data['performance']);
            $eventOfferData->setComment($data['comment']);
            $eventOfferData->setEventTime($event->getTiming());
            $eventOfferData->setUser($this->getUser());

            $eventOfferData->setType($event->getEventType());
            //$eventOfferData->setCountry();
            $eventOfferData->setCity($event->getCity());
            $eventOfferData->setLocation($event->getAddress());
            $eventOfferData->setVenueType($event->getVenueType());
            $eventOfferData->setNumberOfGuests($event->getNumberOfGuests());
            $eventOfferData->setAdditionalInfo($event->getComments());


            $eventManager = $this->get('app.event.manager');
            $chatManager = $this->get('app.chat.manager');

            /** Create ChatRoom */
            $chat = $chatManager->createChat($event, $userArtist, $eventOfferData);


            $order = $this->orderManager->createOrder($event, $artist, $event->getUser()->getClient(), $performances, $chat);
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();

            /** Notify Artist */
            $eventManager->createEventNotify($eventOfferData, $userArtist, $order);
            $eventManager->newMessageNotify($eventOfferData, $userArtist);
        } catch (\Exception $e) {
            $this->entityManager->getConnection()->rollback();

            return new JsonResponse([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(array(
            'status' => 'success',
        ), Response::HTTP_OK);
    }

    /**
     * @ApiDoc(
     *  description="Update order",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when the form has validation errors",
     *     }
     * )
     * @param Event $eventId
     * @param integer $status
     * @return JsonResponse
     */
    public function getOrdersByEventAction($eventId, $status)
    {
        $serializer = $this->get('jms_serializer');
        $eventRepo = $this->entityManager->getRepository('ActedLegalDocsBundle:Event');
        $event = $eventRepo->find($eventId);

        $context = SerializationContext::create()->setGroups('order');

        $orders = $this->orderManager->getOrdersForEvent($event, $status);
        $orders = $serializer->toArray($orders, $context);
        $response = ['status' => 'success', 'orders' => $orders];

        return new JsonResponse($response);
    }
}