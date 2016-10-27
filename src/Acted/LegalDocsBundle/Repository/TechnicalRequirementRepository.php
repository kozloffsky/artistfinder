<?php

namespace Acted\LegalDocsBundle\Repository;

/**
 * TechnicalRequirementRepository
 */
class TechnicalRequirementRepository extends \Doctrine\ORM\EntityRepository
{
    public function getFullTechnicalRequirementById($id)
    {
        $whereCriteria = 'tr.id IN (:trId)';
        return $this->createQueryBuilder('tr')
            ->select('tr, dtr')
            ->leftJoin('tr.documentTechnicalRequirements', 'dtr')
            ->where($whereCriteria)
            ->setParameter('trId', $id)
            ->getQuery()->getArrayResult();
    }

    public function getTechnicalRequirementIdsByArtistId($id)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $params = array('artistId' => $id);

        $whereCriteria = 'tr.artist = :artistId';

        $qb->from('ActedLegalDocsBundle:TechnicalRequirement', 'tr');
        $qb->select('tr.id');
        $qb->where($whereCriteria);
        $qb->setParameters($params);

       return $qb->getQuery()->getResult();

        /*foreach($optionIds as $key => $value) {
            $optionIds[$key] = $value['id'];
        }

        return $optionIds;*/
    }

    public function getFullTechnicalRequirementsByIds($ids)
    {
        $whereCriteria = 'tr.id IN (:trIds)';
        return $this->createQueryBuilder('tr')
            ->select('tr, dtr')
            ->leftJoin('tr.documentTechnicalRequirements', 'dtr')
            ->where($whereCriteria)
            ->setParameter('trIds', $ids)
            ->getQuery()->getArrayResult();
    }
}
