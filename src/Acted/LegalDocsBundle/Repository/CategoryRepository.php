<?php

namespace Acted\LegalDocsBundle\Repository;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends NestedTreeRepository
{
    public function getRecommended()
    {
        return $this->createQueryBuilder('c')
            ->where('c.parent is null')
            ->getQuery()
            ->getResult();
    }
}
