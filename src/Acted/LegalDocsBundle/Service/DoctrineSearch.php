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
    const PER_PAGE = 15;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * @var string
     */
    protected $fakeUsers;


    public function __construct(EntityManagerInterface $entityManagerInterface, PaginatorInterface $paginator,
                                $fakeUsers)
    {
        $this->entityManager = $entityManagerInterface;
        $this->paginator = $paginator;
        $this->fakeUsers = $fakeUsers;
    }

    public function getFilteredArtists(OrderCriteria $oc, FilterCriteria $fc, $page = 1, $limit = 15)
    {
        $artistRepo = $this->entityManager->getRepository('ActedLegalDocsBundle:Artist');
        switch ($this->fakeUsers) {
            case 'show':
                $fake = 0;
                break;
            case 'hide':
                $fake = 1;
                break;
        }
        $artistsQuery = $artistRepo->getFilteredQuery($oc, $fc, $fake);

        return $this->paginator->paginate($artistsQuery, $page, $limit, ['wrap-queries' => true]);
    }


}