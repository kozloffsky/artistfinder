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
}
