<?php

namespace Acted\LegalDocsBundle\Repository;

/**
 * OptionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OptionRepository extends \Doctrine\ORM\EntityRepository
{
    public function removeOptions($ids)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $date = date("Y-m-d H:i:s");
        $params = array('deletedTime' => $date, 'optionIds' => $ids);

        $whereCriteria = 'opt.deletedTime IS NULL AND opt.id IN (:optionIds)';

        $qb->update('ActedLegalDocsBundle:Option', 'opt')
            ->set('opt.deletedTime', ':deletedTime')
            ->where($whereCriteria)
            ->setParameters($params);

        $qb->setParameters($params);

        $qb->getQuery()->execute();
    }

    public function getOptionIdsByPackageIds($ids)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $params = array('packageIds' => $ids);

        $whereCriteria = 'opt.deletedTime IS NULL AND opt.package IN (:packageIds)';
        $date = date("Y-m-d H:i:s");

        $qb->from('ActedLegalDocsBundle:Option', 'opt');
        $qb->select('opt.id');
        $qb->where($whereCriteria);
        $qb->setParameters($params);

        $optionIds = $qb->getQuery()->getResult();

        foreach($optionIds as $key => $value) {
            $optionIds[$key] = $value['id'];
        }

        return $optionIds;
    }

    public function changeOptionSelected($optionId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $params = array('id' => $optionId);

        $whereCriteria = 'o.id = :id';

        $qb->update('ActedLegalDocsBundle:Option', 'o')
            ->set('o.isSelected', '1-o.isSelected')
            ->where($whereCriteria)
            ->setParameters($params);

        return $qb->getQuery()->execute();
    }

    public function setOptionsSelected($optionsIds, $isSelected)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $params = array('ids' => $optionsIds, 'isSelected' => $isSelected);

        $whereCriteria = 'o.id IN (:ids)';

        $qb->update('ActedLegalDocsBundle:Option', 'o')
            ->set('o.isSelected', ':isSelected')
            ->where($whereCriteria)
            ->setParameters($params);

        return $qb->getQuery()->execute();
    }

    public function checkIsSelectedOptionsInPackage($packageId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $params = array('packageId' => $packageId);

        $whereCriteria = 'opt.package IN (:packageId)';

        $qb->from('ActedLegalDocsBundle:Option', 'opt');
        $qb->select('opt.isSelected');
        $qb->where($whereCriteria);
        $qb->setParameters($params);

        $options = $qb->getQuery()->getResult();

        foreach($options as $key => $option) {
            if ($option['isSelected'])
                return true;
        }

        return false;
    }
}