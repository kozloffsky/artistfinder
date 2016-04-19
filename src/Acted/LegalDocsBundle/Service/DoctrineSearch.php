<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 02.04.16
 * Time: 16:58
 */

namespace Acted\LegalDocsBundle\Service;


use Acted\LegalDocsBundle\Search\FilterCriteria;
use Acted\LegalDocsBundle\Search\OrderCriteria;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class DoctrineSearch implements Search
{
    const PER_PAGE = 5;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;


    public function __construct(EntityManagerInterface $entityManagerInterface, PaginatorInterface $paginator)
    {
        $this->entityManager = $entityManagerInterface;
        $this->paginator = $paginator;
    }

    public function getFilteredArtists(OrderCriteria $oc, FilterCriteria $fc, $page = 1)
    {
        $artistRepo = $this->entityManager->getRepository('ActedLegalDocsBundle:Artist');
        $artistsQuery = $artistRepo->getFilteredQuery($oc, $fc);

        return $this->paginator->paginate($artistsQuery, $page, self::PER_PAGE, ['wrap-queries' => true]);
    }


}