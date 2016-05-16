<?php

namespace Acted\LegalDocsBundle\Model;

use Acted\LegalDocsBundle\Popo\EventOfferData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Templating\EngineInterface;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Offer;
use Acted\LegalDocsBundle\Entity\EventOffer;
use Acted\LegalDocsBundle\Model\UserManager;
use Symfony\Component\Validator\Constraints\DateTime;

class EventsManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    protected $mailer;

    protected $mailFrom;

    /**
     * @var EngineInterface
     */
    protected $templating;

    protected $userManager;

    /**
     * EventManager constructor.
     * @param EntityManagerInterface $entityManagerInterface
     * @param $mailer
     * @param $mailFrom
     * @param EngineInterface $templating
     * @param UserManager $userManager
     */
    public function __construct(EntityManagerInterface $entityManagerInterface, $mailer, $mailFrom, EngineInterface
    $templating, UserManager $userManager)
    {
        $this->entityManager = $entityManagerInterface;
        $this->mailer = $mailer;
        $this->mailFrom = $mailFrom;
        $this->templating = $templating;
        $this->userManager = $userManager;
    }

    /**
     * Create new Event
     * @param EventOfferData $eventOfferData
     * @return Event
     */
    public function createEvent(EventOfferData $eventOfferData)
    {
        $event = new Event();
        $date = $eventOfferData->getEventDate();
        $nextDate = new \DateTime(date('Y-m-d h:i:s', strtotime($date->format('Y-m-d h:i:s'))+86400));
        $event->setCity($eventOfferData->getCity());
        $event->setEventRef(uniqid());
        $event->setEventType($eventOfferData->getType());
        $event->setVenueType($eventOfferData->getVenueType());
        $event->setTitle($eventOfferData->getName());
        $event->setStartingDate($date);
        $event->setEndingDate($nextDate);
        $event->setUser($eventOfferData->getUser());
        $event->setIsInternational(1);
        $event->setAddress($eventOfferData->getLocation());
        $event->setTiming($eventOfferData->getEventTime());

        return $event;
    }

    /**
     * Create new Offer
     * @param EventOfferData $eventOfferData
     * @return array Offer
     */
    public function createOffer(EventOfferData $eventOfferData)
    {
        $offer = new Offer();
        $date = new \DateTime();
        $offer->setTitle($eventOfferData->getName() . ' ' . $date->format('d-m-Y H:i:s'));
        foreach ($eventOfferData->getPerformance() as $performance) {
            $offer->addPerformance($performance);
        }

        return $offer;
    }

    /**
     * Create new EventOffer
     * @param EventOfferData $eventOfferData
     * @return EventOffer
     */
    public function createEventOffer(EventOfferData $eventOfferData)
    {
        $eventOffer = new EventOffer();
        $eventOffer->setSendDateTime($eventOfferData->getEventDate());
        $eventOffer->setStatus(EventOffer::EVENT_OFFER_STATUS_PROPOSE);

        return $eventOffer;
    }

    /**
     * Send notify to Artist about new Event
     * @param $eventData
     * @param $artist
     * @param $offer
     */
    public function createEventNotify($eventData, $artist, $offer)
    {
        $rendered = $this->templating->render('@ActedLegalDocs/Email/create_event_notify.html.twig', [
            'event' => $eventData,
            'artist' => $artist,
            'offer' => $offer
        ]);

        $this->userManager->sendEmailMessage($rendered, $this->mailFrom, $artist->getEmail());
    }

    /**
     * Send notify to Artist about new Message
     * @param $eventData
     * @param $artist
     */
    public function newMessageNotify($eventData, $artist)
    {
        $rendered = $this->templating->render('@ActedLegalDocs/Email/new_message_notify.html.twig', [
            'event' => $eventData,
            'artist' => $artist,
        ]);

        $this->userManager->sendEmailMessage($rendered, $this->mailFrom, $artist->getEmail());
    }

    /**
     * @param string $userId
     * @param array $performancesIds
     * @return array
     */
    public function getPerformancesByParams($userId, $performancesIds)
    {
        $em = $this->entityManager;
        $offers = $em
            ->getRepository('ActedLegalDocsBundle:EventOffer')
            ->getAllPerformance($performancesIds, $userId);

        return $offers;
    }

    /**
     * Change status EventOffer
     * @param EventOffer $eventOffer
     * @param string $status
     */
    public function changeStatusOffer(EventOffer $eventOffer, $status)
    {
        $now = new \DateTime();
        $eventOffer->setStatus($status);
        $eventOffer->setReadDateTime($now);
        $this->entityManager->persist($eventOffer);
        $this->entityManager->flush();
    }

}