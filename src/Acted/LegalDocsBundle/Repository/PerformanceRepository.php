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

    /**
     * Get performance by id
     * @param $id
     * @return Performance
     */
    public function getPerformanceById($id)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $params = array('performanceId' => $id);

        $qb->from('ActedLegalDocsBundle:Performance', 'per');
        $qb->select('per');
        $qb->where($qb->expr()->eq('per.id', ':performanceId'));

        $qb->setParameters($params);

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * Get performances
     * @param $profileId
     * @return array
     */
    public function getPerformances($profileId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $params = array('profileId' => $profileId);

        $qb->from('ActedLegalDocsBundle:Performance', 'per');
        $qb->select('per');
        $qb->where('per.deletedTime IS NULL AND per.profile = :profileId');
        $qb->setParameters($params);

        return $qb->getQuery()->getResult();
    }

    public function removePerformance($id)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $date = date("Y-m-d H:i:s");
        $params = array('deletedTime' => $date, 'performanceId' => $id);

        $whereCriteria = 'per.deletedTime IS NULL AND per.id IN (:performanceId)';


        $qb->update('ActedLegalDocsBundle:Performance', 'per')
            ->set('per.deletedTime', ":deletedTime")
            ->where($whereCriteria)
            ->setParameters($params);

        $qb->getQuery()->execute();
    }

    public function getFullPerformanceById($id)
    {
        $whereCriteria = 'p.deletedTime IS NULL AND p.id IN (:performanceId) AND pac.deletedTime IS NULL AND opt.deletedTime IS NULL AND rate.deletedTime IS NULL';
        return $this->createQueryBuilder('p')
            ->select('p, pac, opt, rate, price')
            ->leftJoin('p.packages', 'pac')
            ->leftJoin('pac.options', 'opt')
            ->leftJoin('opt.rates', 'rate')
            ->leftJoin('rate.price', 'price')
            ->where($whereCriteria)
            ->setParameter('performanceId', $id)
            ->getQuery()->getArrayResult();
    }

    public function getPerformancesByProfileId($profileId)
    {
        $whereCriteria = 'p.profile = :profileId AND p.deletedTime IS NULL AND pac.deletedTime IS NULL AND opt.deletedTime IS NULL AND rate.deletedTime IS NULL';
        return $this->createQueryBuilder('p')
            ->select('p, pac, opt, rate, price')
            ->leftJoin('p.packages', 'pac')
            ->leftJoin('pac.options', 'opt')
            ->leftJoin('opt.rates', 'rate')
            ->leftJoin('rate.price', 'price')
            ->where($whereCriteria)
            ->setParameter('profileId', $profileId)
            ->getQuery()->getArrayResult();
    }
}
