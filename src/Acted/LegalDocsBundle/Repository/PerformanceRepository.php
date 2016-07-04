<?php

namespace Acted\LegalDocsBundle\Repository;
use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Performance;

/**
 * PerformanceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PerformanceRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByArtistQuery(Artist $artist, $status)
    {
        $qb =  $this->createQueryBuilder('p')
            ->innerJoin('p.profile', 'pr')
            ->innerJoin('pr.user', 'u')
            ->innerJoin('u.artist', 'a')
            ->where('a = :artist')
            ->setParameter('artist', $artist)
            ;

        if ($status) {
            $qb
                ->andWhere('p.status != :status')
                ->setParameter('status', Performance::STATUS_DRAFT);
        }

        return $qb->orderBy('p.id', 'DESC')->getQuery();
    }
}
