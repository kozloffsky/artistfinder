<?php

namespace Acted\LegalDocsBundle\Model;

use Acted\LegalDocsBundle\Popo\CreateEvent;
use Doctrine\ORM\EntityManagerInterface;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Offer;
use Acted\LegalDocsBundle\Entity\EventOffer;

class EventsManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * EventManager constructor.
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManager = $entityManagerInterface;
    }

    /**
     * @param CreateEvent $createEvent
     * @return Event
     */
    public function createEvent(CreateEvent $createEvent)
    {
        $event = new Event();
        $event->setCity($createEvent->getCity());
        $event->setEventRef(uniqid());
        $event->setEventTypeId($createEvent->getType());
        $event->setVenueTypeId($createEvent->getVenueType());
        $event->setTitle($createEvent->getName());
        $event->setStartingDate($createEvent->getEventDate());
        $event->setTiming($createEvent->getEventTime());

        return $event;
    }

    /**
     * @param CreateEvent $createEvent
     * @return array Offer
     */
    public function createOffer(CreateEvent $createEvent)
    {
        $result = [];
        foreach ($createEvent->getPerformance() as $item) {
            $offer = new Offer();
            $offer->setTitle($createEvent->getName());
            $offer->setPerformance($item);
            $result[] = $offer;
        }

        return $result;
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

}