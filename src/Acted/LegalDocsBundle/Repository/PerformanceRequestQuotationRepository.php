<?php

namespace Acted\LegalDocsBundle\Repository;

use Doctrine\ORM\EntityRepository;

use Acted\LegalDocsBundle\Entity\RequestQuotation;
use Acted\LegalDocsBundle\Entity\Performance;
use Acted\LegalDocsBundle\Entity\PerformanceRequestQuotation;
use Acted\LegalDocsBundle\Entity\Package;
use Acted\LegalDocsBundle\Entity\Price;
use Acted\LegalDocsBundle\Entity\Option;
use Acted\LegalDocsBundle\Entity\Rate;

/**
 * PerformanceRequestQuotationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PerformanceRequestQuotationRepository extends EntityRepository
{
    /**
     * Get performanceRequestQuotations by request id
     * @param $requestId
     * @return array
     */
    public function getPerformanceRequestQuotations($requestId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $params = array('requestId' => $requestId);

        $qb->from('ActedLegalDocsBundle:PerformanceRequestQuotation', 'per_rq');
        $qb->select('per_rq, per, pac, opt, rate, price');
        $qb->leftJoin('per_rq.performance', 'per', 'WITH', 'per.deletedTime IS NULL');
        $qb->leftJoin('per.packages', 'pac', 'WITH', 'pac.deletedTime IS NULL');
        $qb->leftJoin('pac.options', 'opt', 'WITH', 'opt.deletedTime IS NULL');
        $qb->leftJoin('opt.rates', 'rate', 'WITH', 'rate.deletedTime IS NULL');
        $qb->leftJoin('rate.price', 'price');
        $qb->where('per_rq.requestQuotation = :requestId');
        $qb->setParameters($params);

        return $qb->getQuery()->getArrayResult();
    }

    public function getDraftPerformanceRequestQuotations($requestId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $params = array('requestId' => $requestId);

        $qb->from('ActedLegalDocsBundle:PerformanceRequestQuotation', 'per_rq');
        $qb->select('per_rq, per, pac, opt, rate, price');
        $qb->leftJoin('per_rq.performance', 'per');
        $qb->leftJoin('per.packages', 'pac');
        $qb->leftJoin('pac.options', 'opt');
        $qb->leftJoin('opt.rates', 'rate');
        $qb->leftJoin('rate.price', 'price');
        $qb->where('per_rq.requestQuotation = :requestId');
        $qb->setParameters($params);

        return $qb->getQuery()->getArrayResult();
    }

    public function getRelatedPerformanceIds($performanceRequestQuotations)
    {
        $performanceIds = array();
        $packageIds = array();
        $optionIds = array();
        $rateIds = array();
        $priceIds = array();

        foreach ($performanceRequestQuotations as $performanceRequestQuotation) {
            if (empty($performanceRequestQuotation['performance'])) {
                continue;
            }

            $performance = $performanceRequestQuotation['performance'];
            $performanceIds[] = $performance['id'];

            foreach ($performance['packages'] as $package) {
                $packageIds[] = $package['id'];
                foreach ($package['options'] as $option) {
                    $optionIds[] = $option['id'];
                    foreach ($option['rates'] as $rate) {
                        $rateIds[] =  $rate['id'];
                        $priceIds[] = $rate['price']['id'];
                    }
                }
            }
        }

        return array(
            'performanceIds' => $performanceIds,
            'packageIds' => $packageIds,
            'optionIds' => $optionIds,
            'rateIds' => $rateIds,
            'priceIds' => $priceIds
        );
    }

    public function getPerformanceRequestQuotationsByProfileId($profileId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $params = array('profileId' => $profileId);

        $qb->from('ActedLegalDocsBundle:Performance', 'per');
        $qb->select('per, pac, opt, rate, price');
        $qb->leftJoin('per.packages', 'pac', 'WITH', 'pac.deletedTime IS NULL');
        $qb->leftJoin('pac.options', 'opt', 'WITH', 'opt.deletedTime IS NULL');
        $qb->leftJoin('opt.rates', 'rate', 'WITH', 'rate.deletedTime IS NULL');
        $qb->leftJoin('rate.price', 'price');
        $qb->where('per.deletedTime IS NULL AND per.profile = :profileId');
        $qb->setParameters($params);

        return $qb->getQuery()->getResult();
    }

    public function changePerformanceSelected($requestId, $performanceId)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $params = array('requestId' => $requestId, 'performanceId' => $performanceId);

        $whereCriteria = 'per_rq.requestQuotation IN (:requestId) AND per_rq.performance IN (:performanceId)';

        $qb->update('ActedLegalDocsBundle:PerformanceRequestQuotation', 'per_rq')
            ->set('per_rq.isSelected', '1-per_rq.isSelected')
            ->where($whereCriteria)
            ->setParameters($params);

        return $qb->getQuery()->execute();
    }

    public function copyPerformanceRequestQuotation($performanceRequestQuotations, $profile, $requestQuotation, $preSelectedPerformanceIds)
    {
        $em = $this->getEntityManager();

        $performanceIds = array();
        $packageIds = array();
        $optionIds = array();
        $rateIds = array();
        $priceIds = array();

        foreach ($performanceRequestQuotations as $performanceRequestQuotation) {
            if (empty($performanceRequestQuotation['performance']) && !isset($performanceRequestQuotation['packages'])) {
                continue;
            }

            if (empty($performanceRequestQuotation['performance']) && isset($performanceRequestQuotation['packages'])) {
                $performance = $performanceRequestQuotation;
                $isSelected = false;

                if (in_array($performance['id'], $preSelectedPerformanceIds))
                    $isSelected = true;
            } else {
                $performance = $performanceRequestQuotation['performance'];
                $isSelected = $performanceRequestQuotation['isSelected'];
            }

            $performanceIds[] = $performance['id'];
            $copiedPerformance = new Performance();

            $copiedPerformance->setTitle($performance['title']);
            $copiedPerformance->setIsQuotation(true);
            $copiedPerformance->setTechRequirement($performance['techRequirement']);
            $copiedPerformance->setProfile($profile);
            $copiedPerformance->setStatus($performance['status']);
            $copiedPerformance->setIsVisible($performance['isVisible']);
            $copiedPerformance->setType($performance['type']);
            $copiedPerformance->setComment($performance['comment']);
            $em->persist($copiedPerformance);

            /*Connect performances to request*/
            $performanceRequestQuotation = new PerformanceRequestQuotation();
            $performanceRequestQuotation->setPerformance($copiedPerformance);
            $performanceRequestQuotation->setRequestQuotation($requestQuotation);
            $performanceRequestQuotation->setIsSelected($isSelected);
            $em->persist($performanceRequestQuotation);

            foreach ($performance['packages'] as $package) {

                $packageIds[] = $package['id'];

                $copiedPackage = new Package();
                $copiedPackage->setProfile($profile);
                $copiedPackage->setPerformance($copiedPerformance);
                $copiedPackage->setIsSelected($package['isSelected']);
                $copiedPackage->setName($package['name']);
                $em->persist($copiedPackage);

                foreach ($package['options'] as $option) {

                    $optionIds[] = $option['id'];

                    $copiedOption = new Option();
                    $copiedOption->setPackage($copiedPackage);
                    $copiedOption->setDuration($option['duration']);
                    $copiedOption->setQty($option['qty']);
                    $copiedOption->setIsSelected($option['isSelected']);
                    $copiedOption->setPriceOnRequest($option['priceOnRequest']);
                    $em->persist($copiedOption);

                    foreach ($option['rates'] as $rate) {
                        $rateIds[] =  $rate['id'];

                        $price = new Price();
                        $price->setAmount($rate['price']['amount']);
                        $em->persist($price);

                        $priceIds[] = $rate['price']['id'];

                        $copiedRate = new Rate();
                        $copiedRate->setOption($copiedOption);
                        $copiedRate->setPrice($price);
                        $em->persist($copiedRate);
                    }
                }
            }
        }


        $em->flush();

        return array(
            'performanceIds' => $performanceIds,
            'packageIds' => $packageIds,
            'optionIds' => $optionIds,
            'rateIds' => $rateIds,
            'priceIds' => $priceIds
        );
    }
}