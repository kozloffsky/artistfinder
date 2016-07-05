<?php

namespace Acted\LegalDocsBundle\Repository;

use Acted\LegalDocsBundle\Entity\Category;
use Acted\LegalDocsBundle\Entity\Artist;

/**
 * RecommendRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecommendRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param Category $category
     * @param Artist $artist
     * @param int $value
     * @return array
     */
    public function findRecommendByData(Category $category, Artist $artist, $value)
    {
        return $this->createQueryBuilder('r')
            ->where('r.category = :category')
            ->andWhere('r.artist != :artist')
            ->andWhere('r.value >= :value')
            ->setParameters([
                'category' => $category->getId(),
                'artist' => $artist,
                'value' => $value,
            ])
            ->orderBy('r.value', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
