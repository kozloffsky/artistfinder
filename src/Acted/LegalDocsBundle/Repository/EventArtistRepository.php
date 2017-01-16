<?php

namespace Acted\LegalDocsBundle\Repository;

use Acted\LegalDocsBundle\Entity\Event;

/**
 * EventArtistRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventArtistRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get artists in event
     * @param Event $event
     * @param integer $page
     * @param integer $size
     * @return array
     */
    public function getEventArtists($event, $page = 1, $size = 2)
    {
        if ($page == 1) {
            $offset = 0;
        } else {
            $offset = $page * $size;
            $offset -= $size;
        }

        $whereCriteria = "ea.event = :event";

        $params = array('event' => $event);

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $qb->from('ActedLegalDocsBundle:Order', 'ea')
            ->select('IDENTITY(ea.artist)')
            ->where($whereCriteria)
            ->setFirstResult($offset)
            ->setMaxResults($size)
            ->setParameters($params);

        $eventArtists = $qb->getQuery()->getArrayResult();

        $qb = $this->createQueryBuilder('ea')
            ->select('count(ea.id) as countRows')
            ->where($whereCriteria)
            ->setFirstResult($offset)
            ->setMaxResults($size)
            ->setParameters($params);

        $artistsCount = $qb->getQuery()->getOneOrNullResult();

        $artists = array();

        foreach ($eventArtists as $eventArtist) {
            $artists[] = $eventArtist[1];
        }

        $whereCriteria = "a.id IN (:artists)";

        $params = array('artists' => $artists);

        $qb = $em->createQueryBuilder();
        $qb->from('ActedLegalDocsBundle:Artist', 'a')
            ->select('a, f')
            ->leftJoin('a.feedbacks', 'f')
            ->where($whereCriteria)
            ->setParameters($params);

        $eventArtists = $qb->getQuery()->getArrayResult();

        return array(
            'artists' => $eventArtists,
            'countRows' => $artistsCount['countRows']
        );
    }
}
