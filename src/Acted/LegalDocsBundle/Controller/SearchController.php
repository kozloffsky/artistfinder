<?php

namespace Acted\LegalDocsBundle\Controller;


use Acted\LegalDocsBundle\Form\SearchType;
use Acted\LegalDocsBundle\Search\FilterCriteria;
use Acted\LegalDocsBundle\Search\OrderCriteria;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\VarDumper\VarDumper;

class SearchController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('jms_serializer');
        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);

        $data = $searchForm->getData();

        $s = $this->get('app.search');

        $recommendedCategories = $em->getRepository('ActedLegalDocsBundle:Category')->getRecommended();
        $artistRepo = $em->getRepository('ActedLegalDocsBundle:Artist');
        $recommended = [];

        foreach ($recommendedCategories as $category) {
            $recommended[] = [
                'category' => $category,
                'artists' => $serializer->toArray($artistRepo->getRecommended($category), SerializationContext::create()->setGroups(['block']))
            ];
        }

        $oc = new OrderCriteria(OrderCriteria::TOP_RATED, OrderCriteria::CHEAPEST);
        $fc = new FilterCriteria($data['categories'], true, $data['query']);
        $fc->addDistance($data['user_region'], $data['distance']);

        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();


        return $this->render('ActedLegalDocsBundle:Default:search.html.twig', compact('categories', 'recommended'));
        //VarDumper::dump($s->getFilteredArtists($oc, $fc));
        //die;
    }
}
