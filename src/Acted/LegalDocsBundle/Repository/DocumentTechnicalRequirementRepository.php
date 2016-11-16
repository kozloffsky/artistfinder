<?php

namespace Acted\LegalDocsBundle\Repository;

use Acted\LegalDocsBundle\Entity\DocumentTechnicalRequirement;

/**
 * DocumentTechnicalRequirementRepository
 */
class DocumentTechnicalRequirementRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get document technical requirements by technical requirement id
     * @param $id
     * @return DocumentTechnicalRequirement
     */
    public function getDocumentsByTRId($id)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $params = array('technicalRequirement' => $id);

        $qb->from('ActedLegalDocsBundle:DocumentTechnicalRequirement', 'dtr');
        $qb->select('dtr');
        $qb->where($qb->expr()->eq('dtr.technicalRequirement', ':technicalRequirement'));

        $qb->setParameters($params);

        return $qb->getQuery()->getArrayResult();
    }


    /**
     * Get document technical requirements by lastId
     * @param $id
     * @return DocumentTechnicalRequirement
     */
    public function getDocumentsAfterId($id, $technicalRequirementId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $params = array('documentTechnicalRequirement' => $id, 'technicalRequirement' => $technicalRequirementId);

        $qb->from('ActedLegalDocsBundle:DocumentTechnicalRequirement', 'dtr');
        $qb->select('dtr');
        $qb->where('dtr.id > :documentTechnicalRequirement AND dtr.technicalRequirement = :technicalRequirement');

        $qb->setParameters($params);

        return $qb->getQuery()->getArrayResult();
    }
}
