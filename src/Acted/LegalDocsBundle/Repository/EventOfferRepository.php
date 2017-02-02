<?php

namespace Acted\LegalDocsBundle\Repository;

use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\EventOffer;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * EventOfferRepository
 */
class EventOfferRepository extends EntityRepository
{
    /**
     * @param int $userId
     * @return array
     */
    public function getEventsByUserId($userId)
    {
        return $this->createQueryBuilder('eo')
            ->leftJoin('eo.event', 'e')
            ->where('e.user = :userId')
            ->groupBy('e.id')
            ->orderBy('eo.sendDateTime', 'DESC')
            ->setParameter('userId', $userId)
            ->getQuery()->getResult();
    }

    public function getArtists($userId)
    {
        return $this->createQueryBuilder('eo')
            ->select('a.slug as user_slug, e.id as event_id')
            ->leftJoin('eo.event', 'e')
            ->leftJoin('eo.offer', 'o')
            ->leftJoin('o.performances', 'p')
            ->leftJoin('p.profile', 'pr')
            ->leftJoin('pr.user', 'u')
            ->leftJoin('u.artist', 'a')
            ->where('e.user = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()->getArrayResult();
    }

    /**
     * @param Event $event
     * @param string $userId
     * @return object|null
     */
    public function getOfferByParams($event, $userId)
    {
        return $this->createQueryBuilder('eo')
            ->leftJoin('eo.event', 'e')
            ->leftJoin('eo.offer', 'o')
            ->leftJoin('o.performances', 'p')
            ->leftJoin('p.profile', 'pr')
            ->where('pr.user = :userId')
            ->andWhere('eo.event = :event')
            ->setParameters([
                'userId' => $userId,
                'event' => $event
            ])
            ->getQuery()->getResult();
    }

    /**
     *  Returns event by it id
     *  @param int eventId
     *  @return object|null
     */
    public function getEventOfferByEventId($eventId) {
        return $this->createQueryBuilder('eo')
            ->leftJoin('eo.event', 'e')
            ->leftJoin('eo.offer', 'o')
            ->leftJoin('e.user', 'u')
            ->where('e.id = :eventId')
            ->setParameter('eventId', $eventId)
            ->getQuery()->getResult();
    }

	/**
     * @param Event $event
     * @return object|null
     */
    public function getPerformanceIds($event, $artist)
    {
        $eventOffer = $this->createQueryBuilder('eo')
            ->select('eo, o')
            ->leftJoin('eo.offer', 'o')
            ->where('eo.event = :event AND eo.artist = :artist')
            ->setParameters([
                'event' => $event,
                'artist' => $artist
            ])
            ->getQuery()->getOneOrNullResult();

        $performanceIds = array();

        if (empty($eventOffer) || empty($eventOffer->getOffer()) || empty($eventOffer->getOffer()->getPerformances()))
            return $performanceIds;

        foreach ($eventOffer->getOffer()->getPerformances() as $performance) {
            $performanceIds[] = $performance->getId();
        }

        return $performanceIds;
    }


    /**
     * @Secure(roles="ROLE_ACTOR")
     * @param int $eventId
     *
     */
    public function acceptDetails($eventId){
        $this->accept(EventOffer::PROP_DETAILS, $eventId);
    }

    /**
     * @Secure(roles="ROLE_CLIENT")
     * @param int $eventId
     *
     */
    public function acceptTechRequirements($eventId){
        $eventOffer = $this->findOneBy(array("event"=>$eventId));
        // do nothing if already accepted
        if($eventOffer->getTechnicalRequirementsAccepted()) return;
        $eventOffer->setTechnicalRequirementsAccepted(true);
        $this->_em->persist($eventOffer);
        $this->_em->flush();

    }

    public function accept($propName, $eventId){
        $eventOffer = $this->findOneBy(array("event"=>$eventId));
        $getter = 'get'.$propName.'Accepted';
        $setter = 'set'.$propName.'Accepted';
        // do nothing if already accepted
        if($eventOffer->$getter()) return;

        $eventOffer->$setter(true);
        $this->_em->persist($eventOffer);
        $this->_em->flush();
    }

    public function getEventArtist(Event $event){

    }
}
