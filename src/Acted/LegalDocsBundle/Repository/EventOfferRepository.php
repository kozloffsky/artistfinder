<?php

namespace Acted\LegalDocsBundle\Repository;

use Doctrine\ORM\EntityRepository;

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
     * @param Event $event
     * @return object|null
     */
    public function getPerformanceIds($event)
    {
        $eventOffer = $this->createQueryBuilder('eo')
            ->select('eo, o')
            ->leftJoin('eo.offer', 'o')
            ->where('eo.event = :event')
            ->setParameters([
                'event' => $event
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
}
