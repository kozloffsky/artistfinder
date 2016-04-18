<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Form\SearchType;
use Acted\LegalDocsBundle\Search\FilterCriteria;
use Acted\LegalDocsBundle\Search\OrderCriteria;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;

class ArtistController extends Controller
{
    /**
     * Artist list
     * @Rest\View(serializerGroups={"block"})
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

        if ($searchForm->isSubmitted() && (!$searchForm->isValid())) {
            return View::create($this->get('app.form_errors_serializer')->serializeFormErrors($searchForm), 400);
        }

        $data = $searchForm->getData();

        $s = $this->get('app.search');

        $oc = new OrderCriteria(OrderCriteria::TOP_RATED, OrderCriteria::CHEAPEST);
        $fc = new FilterCriteria($data['categories'], true, $data['query']);

        if ($data['distance']) {
            $fc->addDistance($data['user_region'], $data['distance']);
        }

        $filteredArtists = $s->getFilteredArtists($oc, $fc);
        return iterator_to_array($filteredArtists);
    }
}
