<?php

namespace Acted\LegalDocsBundle\Repository;

use Acted\LegalDocsBundle\Entity\Artist;

/**
 * FeedbackRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FeedbackRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get artist feedbacks
     * @param Artist $artist
     * @param integer $page
     * @param integer $size
     * @return array
     */
    public function getArtistFeedbacks($artist, $page = 1, $size = 3)
    {
        if ($page == 1) {
            $offset = 0;
        } else {
            $offset = $page * $size;
            $offset -= $size;
        }

        $whereCriteria = "f.artist = :artist";

        $params = array('artist' => $artist);

        $qb = $this->createQueryBuilder('f')
            ->select('f')
            ->where($whereCriteria)
            ->setFirstResult($offset)
            ->setMaxResults($size)
            ->setParameters($params);


        $feedbacks = $qb->getQuery()->getArrayResult();

        $qb = $this->createQueryBuilder('f')
            ->select('count(f.id) as countRows')
            ->where($whereCriteria)
            ->setFirstResult($offset)
            ->setMaxResults($size)
            ->setParameters($params);


        $feedbackCount = $qb->getQuery()->getOneOrNullResult();

        return array(
            'feedbacks' => $feedbacks,
            'countRows' => $feedbackCount['countRows']
        );
    }

    public function getAverageArtistRating($artist)
    {
        $whereCriteria = "f.artist = :artist";
        $params = array('artist' => $artist);

        $qb = $this->createQueryBuilder('f')
            ->select('avg(f.rating) as averageRating')
            ->where($whereCriteria)
            ->setParameters($params);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
