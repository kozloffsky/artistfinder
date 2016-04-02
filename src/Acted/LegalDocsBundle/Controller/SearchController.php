<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Search\FilterCriteria;
use Acted\LegalDocsBundle\Search\OrderCriteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class SearchController extends Controller
{
    public function indexAction(Request $request)
    {
        $s = $this->get('app.search');

        $oc = new OrderCriteria(OrderCriteria::TOP_RATED, OrderCriteria::CHEAPEST);
        $fc = new FilterCriteria(true);

        VarDumper::dump($s->getFilteredArtists($oc, $fc));
        die;
    }
}
