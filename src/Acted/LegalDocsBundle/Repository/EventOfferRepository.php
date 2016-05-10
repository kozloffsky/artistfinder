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
}
