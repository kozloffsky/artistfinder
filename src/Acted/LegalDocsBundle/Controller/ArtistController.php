<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Form\SearchType;
use Acted\LegalDocsBundle\Search\FilterCriteria;
use Acted\LegalDocsBundle\Search\OrderCriteria;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;

class ArtistController extends Controller
{
    /**
     * Artist list
     * @Rest\View
     * @ApiDoc(
     *  resource=true,
     *  description="Artist search",
     *  input="Acted\LegalDocsBundle\Form\SearchType",
     * )
     */
    public function indexAction(Request $request)
    {
        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);

        $data = $searchForm->getData();

        $s = $this->get('app.search');

        $oc = new OrderCriteria(OrderCriteria::TOP_RATED, OrderCriteria::CHEAPEST);
        $fc = new FilterCriteria($data['categories'], true, $data['query']);

        $filteredArtists = $s->getFilteredArtists($oc, $fc);
        return iterator_to_array($filteredArtists);
    }
}
