<?php

namespace Acted\LegalDocsBundle\Model;

use Acted\LegalDocsBundle\Popo\CreateEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Templating\EngineInterface;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Offer;
use Acted\LegalDocsBundle\Entity\EventOffer;
use Acted\LegalDocsBundle\Model\UserManager;

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
     * @param CreateEvent $createEvent
     * @return Event
     */
    public function createEvent(CreateEvent $createEvent)
    {
        $event = new Event();
        $date = $createEvent->getEventDate();
        $nextDate = $date->add(new \DateInterval('P1D'));
        $event->setCity($createEvent->getCity());
        $event->setEventRef(uniqid());
        $event->setEventType($createEvent->getType());
        $event->setVenueType($createEvent->getVenueType());
        $event->setTitle($createEvent->getName());
        $event->setStartingDate($date);
        $event->setEndingDate($nextDate);
        $event->setUser($createEvent->getUser());
        $event->setIsInternational(1);
        $event->setAddress($createEvent->getLocation());
        $event->setTiming($createEvent->getEventTime());

        return $event;
    }

    /**
     * @param CreateEvent $createEvent
     * @return array Offer
     */
    public function createOffer(CreateEvent $createEvent)
    {
        $offer = new Offer();
        $date = new \DateTime();
        $offer->setTitle($createEvent->getName() . ' ' . $date->format('d-m-Y H:i:s'));
        foreach ($createEvent->getPerformance() as $performance) {
            $offer->addPerformance($performance);
        }

        return $offer;
    }

    /**
     * @param CreateEvent $createEvent
     * @return EventOffer
     */
    public function createEventOffer(CreateEvent $createEvent)
    {
        $eventOffer = new EventOffer();
        $eventOffer->setSendDateTime($createEvent->getEventDate());
        $eventOffer->setStatus(EventOffer::EVENT_OFFER_STATUS_PROPOSE);

        return $eventOffer;
    }

    /**
     * @param $eventData
     * @param $artist
     */
    public function createEventNotify($eventData, $artist)
    {
        $rendered = $this->templating->render('@ActedLegalDocs/Email/create_event_notify.html.twig', [
            'event' => $eventData,
            'artist' => $artist,
        ]);

        $this->userManager->sendEmailMessage($rendered, $this->mailFrom, $artist->getEmail());
    }

    /**
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

}