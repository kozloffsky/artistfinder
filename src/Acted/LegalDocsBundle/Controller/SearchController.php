<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Form\SearchType;
use Acted\LegalDocsBundle\Search\FilterCriteria;
use Acted\LegalDocsBundle\Search\OrderCriteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class SearchController extends Controller
{
    public function indexAction(Request $request)
    {
        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);

        $data = $searchForm->getData();

        $s = $this->get('app.search');

        $oc = new OrderCriteria(OrderCriteria::TOP_RATED, OrderCriteria::CHEAPEST);
        $fc = new FilterCriteria($data['categories'], true);

        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();


        return $this->render('ActedLegalDocsBundle:Default:search.html.twig', compact('categories'));
        //VarDumper::dump($s->getFilteredArtists($oc, $fc));
        //die;
    }
}
