<?php

namespace Acted\LegalDocsBundle\Repository;

/**
 * RateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RateRepository extends \Doctrine\ORM\EntityRepository
{
    public function removeRates($ids)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $date = date("Y-m-d H:i:s");
        $params = array('deletedTime' => $date, 'rateIds' => $ids);

        $whereCriteria = 'rate.deletedTime IS NULL AND rate.id IN (:rateIds)';

        $qb->update('ActedLegalDocsBundle:Rate', 'rate')
            ->set('rate.deletedTime', ':deletedTime')
            ->where($whereCriteria)
            ->setParameters($params);

        $qb->setParameters($params);

        $qb->getQuery()->execute();
    }

    public function setIsSelectRateByOptionId($id, $isSelected = true)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $params = array('optionId' => $id, 'isSelected' => $isSelected);

        $whereCriteria = 'rate.deletedTime IS NULL AND rate.option = (:optionId)';

        $qb->update('ActedLegalDocsBundle:Rate', 'rate')
            ->set('rate.isSelected', ':isSelected')
            ->where($whereCriteria)
            ->setParameters($params);

        $qb->setParameters($params);

        $qb->getQuery()->execute();
    }

    public function getRateIdsByOptionIds($ids)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $params = array('optionIds' => $ids);

        $whereCriteria = 'rate.deletedTime IS NULL AND rate.option IN (:optionIds)';
        $date = date("Y-m-d H:i:s");

        $qb->from('ActedLegalDocsBundle:Rate', 'rate');
        $qb->select('rate.id');
        $qb->where($whereCriteria);
        $qb->setParameters($params);

        $rateIds = $qb->getQuery()->getResult();
        foreach($rateIds as $key => $value) {
            $rateIds[$key] = $value['id'];
        }

        return $rateIds;
    }

    public function getPriceIdsByRateIds($id)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $params = array('rateId' => $id);

        $whereCriteria = 'rate.deletedTime IS NULL AND rate.id = :rateId';

        $qb->from('ActedLegalDocsBundle:Rate', 'rate');
        $qb->select('rate');
        $qb->where($whereCriteria);
        $qb->setParameters($params);

        $priceId = array();
        $rate = $qb->getQuery()->getSingleResult();
        return $rate->getPrice()->getId();
    }
}
