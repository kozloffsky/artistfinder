<?php

namespace Acted\LegalDocsBundle\Repository;

use Acted\LegalDocsBundle\Entity\Category;
use Acted\LegalDocsBundle\Entity\Performance;
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
            ->where('a.recommend != 0')
            ->innerJoin('a.user', 'u')
            ->innerJoin('u.profile', 'p')
            ->innerJoin('p.performances', 'perf')
            ->andWhere('perf.status != :status')
            ->andWhere(':category MEMBER OF p.categories')
            ->setParameter('category', $category)
            ->setParameter('status', Performance::STATUS_DRAFT)
            ->getQuery()
            ->getResult();
    }

    public function getFilteredQuery(OrderCriteria $oc, FilterCriteria $fc)
    {
        $needRegionJoin = ($fc->getCountry()
            || ($fc->getLocation() && in_array($fc->getLocation(), [FilterCriteria::LOCATION_SAME_COUNTRY, FilterCriteria::LOCATION_100_KM])));

        $needDistanceSelect = (($fc->getMaxDistance() !== FilterCriteria::DISTANCE_ANY && $fc->getMaxDistance() !== false)
            || ($fc->getLocation() && $fc->getLocation() == FilterCriteria::LOCATION_100_KM));

        $qb = $this->createQueryBuilder('a')
            ->addSelect('AVG(ar.rating) AS HIDDEN rating_avg')
            ->innerJoin('a.user', 'u')
            ->innerJoin('u.profile', 'p')
            ->innerJoin('p.performances', 'pr')
            ->leftJoin('pr.offers', 'o')
            ->leftJoin('a.ratings', 'ar')
            ->where('u.active != 0')
            ->andWhere('pr.status != :status_pr')
            ->setParameter('status_pr', Performance::STATUS_DRAFT)
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

        if ($fc->getRecommended()) {
            $qb->andWhere('a.recommend != 0')
                ->addOrderBy('a.recommend', 'ASC');
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

        if ($fc->getRegion() || $needRegionJoin) {
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

        if ($fc->getMaxDistance() !== FilterCriteria::DISTANCE_ANY && $fc->getMaxDistance() !== false) {
                $qb->andHaving('distance >= :minDistance')
                ->andHaving('distance <= :maxDistance')
                ->setParameter('minDistance', 0)
                ->setParameter('maxDistance', $fc->getMaxDistance());
        }

        switch($fc->getLocation()) {
            case FilterCriteria::LOCATION_SAME_COUNTRY;
                if ($fc->getUserCity()) {
                    $userCountry = $fc->getUserCity()->getRegion()->getCountry();
                } else {
                    $userCountry = $fc->getCountry();
                }

                $qb->andWhere('r.country = :userCountry')
                    ->setParameter('userCountry', $userCountry);
                break;
            case FilterCriteria::LOCATION_INTERNATIONAL;
                $qb->andWhere('p.isInternational = :international')
                    ->setParameter('international', true);
                break;
            case FilterCriteria::LOCATION_100_KM;
                $qb->andHaving('distance <= :locationDistance')
                    ->setParameter('locationDistance', 160);
                break;
        }


        if ($fc->getRegion()) {
            $qb->andWhere('city.region = :region')
                ->setParameter('region', $fc->getRegion());
        }

        if ($fc->getCountry() && !$fc->getUserCity()) {
            $qb->andWhere('r.country = :country')
                ->setParameter('country', $fc->getCountry());
        }

        $qb->addOrderBy('a.spotlight', 'ASC');

        return $qb->getQuery();
    }

    /**
     * @param string $query
     * @param int $start
     * @param int $end
     * @param bool $recommend
     * @param bool $spotlight
     * @return \Doctrine\ORM\Query
     */
    public function getArtistsList($query = null, $start = null, $end = null, $recommend = false, $spotlight = false)
    {
        $qb =  $this->createQueryBuilder('a')
            ->innerJoin('a.user', 'u')
            ->where('u.active != 0');
        if ($query) {
            $qb
                ->andWhere('(MATCH(a.name, a.assistantName) AGAINST (:query BOOLEAN) > 0)')
                ->setParameter('query', $query);
        }
        if ($start) {
            $qb
                ->andWhere('a.recommend >= :start')
                ->setParameter('start', (int)$start);
        }
        if($end) {
            $qb
                ->andWhere('a.recommend <= :end')
                ->setParameter('end', (int)$end);
        }
        if ($recommend) {
            $qb
                ->andWhere('a.recommend IS NOT NULL')
                ->orderBy('a.recommend', 'ASC');
        }
        if ($spotlight) {
            $qb
                ->andWhere('a.spotlight IS NOT NULL')
                ->orderBy('a.spotlight', 'ASC');
        }

        return $qb->getQuery();
    }

    /**
     * @param string $query
     * @param int $start
     * @param int $end
     * @param bool $recommend
     * @param bool $spotlight
     * @return \Doctrine\ORM\Query
     */
    public function getArtistsList($query = null, $start = null, $end = null, $recommend = false, $spotlight = false)
    {
        $qb =  $this->createQueryBuilder('a')
            ->innerJoin('a.user', 'u')
            ->where('u.active != 0');
        if ($query) {
            $qb
                ->andWhere('(MATCH(a.name, a.assistantName) AGAINST (:query BOOLEAN) > 0)')
                ->setParameter('query', $query);
        }
        if ($start) {
            $qb
                ->andWhere('a.recommend >= :start')
                ->setParameter('start', (int)$start);
        }
        if($end) {
            $qb
                ->andWhere('a.recommend <= :end')
                ->setParameter('end', (int)$end);
        }
        if ($recommend) {
            $qb
                ->andWhere('a.recommend != 0')
                ->orderBy('a.recommend', 'ASC');
        }
        if ($spotlight) {
            $qb
                ->andWhere('a.spotlight != 0')
                ->orderBy('a.spotlight', 'ASC');
        }

        return $qb->getQuery();
    }
}
