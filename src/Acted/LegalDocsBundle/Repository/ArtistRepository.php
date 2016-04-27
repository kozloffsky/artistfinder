<?php

namespace Acted\LegalDocsBundle\Repository;

use Acted\LegalDocsBundle\Entity\Category;
use Acted\LegalDocsBundle\Search\FilterCriteria;
use Acted\LegalDocsBundle\Search\OrderCriteria;

/**
 * ArtistRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArtistRepository extends \Doctrine\ORM\EntityRepository
{

    public function getRecommended(Category $category)
    {
        return $this->createQueryBuilder('a')
            ->where('a.recommend = :recommend')
            ->setParameter('recommend', true)
            ->innerJoin('a.user', 'u')
            ->innerJoin('u.profile', 'p')
            ->andWhere(':category MEMBER OF p.categories')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function getFilteredQuery(OrderCriteria $oc, FilterCriteria $fc)
    {
        $needRegionJoin = ($fc->getCountry()
            || ($fc->getLocation() && in_array($fc->getLocation(), [FilterCriteria::LOCATION_SAME_COUNTRY, FilterCriteria::LOCATION_100_KM])));

        $needDistanceSelect = ($fc->getMinDistance() !== false
            || ($fc->getLocation() && $fc->getLocation() == FilterCriteria::LOCATION_100_KM));

        $qb = $this->createQueryBuilder('a')
            ->addSelect('AVG(ar.rating) AS HIDDEN rating_avg')
            ->innerJoin('a.user', 'u')
            ->innerJoin('u.profile', 'p')
            ->innerJoin('p.performances', 'pr')
            ->innerJoin('pr.offers', 'o')
            ->leftJoin('a.ratings', 'ar')
            ->groupBy('a.id');

        if ($fc->withVideo()) {
            $qb->innerJoin('pr.media', 'prm')
                ->andWhere('prm.mediaType = :mediaType')
                ->setParameter('mediaType', 'video');
        }

        if ($fc->getQuery()) {
            $qb->andWhere('(MATCH(a.name, a.assistantName) AGAINST (:query BOOLEAN) > 0
                OR MATCH(p.title, p.description, p.header) AGAINST (:query BOOLEAN) > 0
                OR MATCH(pr.title, pr.techRequirement) AGAINST (:query BOOLEAN) > 0 )')
                ->setParameter('query', $fc->getQuery());
        }

        $categories = $fc->getCategories();
        if (count($categories) > 0) {
            $qb->innerJoin('p.categories', 'c')
                ->andWhere('c IN (:categories)')
                ->setParameter('categories', $categories);
        }

        $priceFunction = ($oc->getPriceOrder() == 'ASC') ? 'MIN' : 'MAX';
        $qb->addSelect($priceFunction.'(o.price) AS HIDDEN price_agr');
        if ($oc->getPrioritized() == 'rating') {
            $qb->addOrderBy('rating_avg', $oc->getRatingOrder())
                ->addOrderBy('price_agr', $oc->getPriceOrder());
        } else {
            $qb->addOrderBy('price_agr', $oc->getPriceOrder())
                ->addOrderBy('rating_avg', $oc->getRatingOrder());
        }

        if (($fc->getMinDistance() !== false) || $fc->getRegion() || $needRegionJoin) {
            $qb->innerJoin('a.city', 'city');
        }

        if ($needRegionJoin) {
            $qb->innerJoin('city.region', 'r');
        }

        if ($needDistanceSelect) {
            $qb->addSelect('(6371*ACOS(COS(RADIANS(:latitude))
                        *COS(RADIANS(city.latitude))*COS(RADIANS(city.longitude)-RADIANS(:longitude))
                        + SIN(RADIANS(:latitude) ) * SIN(RADIANS(city.latitude)))) AS HIDDEN distance')
                ->setParameter('latitude', $fc->getUserLatitude())
                ->setParameter('longitude', $fc->getUserLongitude());
        }

        if ($fc->getMinDistance() !== false) {
                $qb->andHaving('distance >= :minDistance')
                ->andHaving('distance <= :maxDistance')
                ->setParameter('minDistance', $fc->getMinDistance())
                ->setParameter('maxDistance', $fc->getMaxDistance());
        }

        switch($fc->getLocation()) {
            case FilterCriteria::LOCATION_SAME_COUNTRY;
                $qb->andWhere('r.country = :userCountry')
                    ->setParameter('userCountry', $fc->getUserRegion()->getCountry());
                break;
            case FilterCriteria::LOCATION_INTERNATIONAL;
                $qb->andWhere('p.isInternational = :international')
                    ->setParameter('international', true);
                break;
            case FilterCriteria::LOCATION_100_KM;
                $qb->andHaving('distance <= :locationDistance')
                    ->setParameter('locationDistance', 100);
                break;
        }


        if ($fc->getRegion()) {
            $qb->andWhere('city.region = :region')
                ->setParameter('region', $fc->getRegion());
        }

        if ($fc->getCountry()) {
            $qb->andWhere('r.country = :country')
                ->setParameter('country', $fc->getCountry());
        }

        if ($fc->getRecommended()) {
            $qb->andWhere('a.recommend = :recommend')
                ->setParameter('recommend', true);
        }

        return $qb->getQuery();
    }
}
