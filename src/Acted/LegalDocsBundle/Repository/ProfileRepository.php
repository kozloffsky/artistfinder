<?php

namespace Acted\LegalDocsBundle\Repository;

/**
 * ProfileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProfileRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * switch showing feedback and rating
     * @param $profileId
     * @return array
     */
    public function switchFeedbacks($id)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $params = array('id' => $id);

        $whereCriteria = 'pr.id IN (:id)';


        $qb->update('ActedLegalDocsBundle:Profile', 'pr')
            ->set('pr.showRating', "1-pr.showRating")
            ->set('pr.showFeedbacks', "1-pr.showFeedbacks")
            ->where($whereCriteria)
            ->setParameters($params);

        $qb->getQuery()->execute();
    }
}
