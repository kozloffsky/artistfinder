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
            ->orderBy('e.startingDate', 'DESC')
            ->setParameter('userId', $userId)
            ->getQuery()->getResult();
    }

    public function getArtists($userId)
    {
        return $this->createQueryBuilder('eo')
            ->select('u.id as user_id, e.id as event_id')
            ->leftJoin('eo.event', 'e')
            ->leftJoin('eo.offer', 'o')
            ->leftJoin('o.performances', 'p')
            ->leftJoin('p.profile', 'pr')
            ->leftJoin('pr.user', 'u')
            ->where('e.user = :userId')
            ->groupBy('u.id')
            ->setParameter('userId', $userId)
            ->getQuery()->getResult();
    }

    /**
     * @param array $performances
     * @param string $userId
     * @return array
     */
    public function getAllPerformance($performances, $userId)
    {
        return $this->createQueryBuilder('eo')
            ->select('p.id, p.title')
            ->leftJoin('eo.event', 'e')
            ->leftJoin('eo.offer', 'o')
            ->leftJoin('o.performances', 'p')
            ->where('e.user = :userId')
            ->andWhere('p.id IN (:performances)')
            ->groupBy('p.id')
            ->setParameters([
                'userId' => $userId,
                'performances' => $performances
            ])
            ->getQuery()->getResult();
    }
}
