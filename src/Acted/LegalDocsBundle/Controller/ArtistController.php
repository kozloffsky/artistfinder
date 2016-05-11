<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Form\SearchType;
use Acted\LegalDocsBundle\Search\FilterCriteria;
use Acted\LegalDocsBundle\Search\OrderCriteria;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\VarDumper\VarDumper;

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

        $oc = OrderCriteria::createSimpleSort($data['order']);
        $fc = new FilterCriteria($data['categories'], $data['with_video'], $data['query']);

        if ($data['distance']) {
            $fc->addDistance($data['user_city'], $data['distance']);
        }

        $fc->addGeo($data['country'], $data['region']);
        $fc->addLocation($data['user_city'], $data['location']);
        $fc->addRecommended($data['recommended']);

        $page = ($data['page']) ? $data['page'] : 1;
        $filteredArtists = $s->getFilteredArtists($oc, $fc, $page);
        return iterator_to_array($filteredArtists);
    }

    /**
     * Artist list by sub-categories
     * @Rest\View(serializerGroups={"block"})
     * @ApiDoc(
     *  resource=true,
     *  description="Artist search that sorted by sub-categories",
     *  input="Acted\LegalDocsBundle\Form\SearchType",
     * )
     */
    public function batchAction(Request $request)
    {
        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && (!$searchForm->isValid())) {
            return View::create($this->get('app.form_errors_serializer')->serializeFormErrors($searchForm), 400);
        }
        $data = $searchForm->getData();
        $s = $this->get('app.search');

        $oc = OrderCriteria::createSimpleSort($data['order']);
        $result = [];

        if ($data['categories'] instanceof \Traversable) {
            foreach ($data['categories'] as $category) {
                $fc = new FilterCriteria([$category], $data['with_video'], $data['query']);
                if ($data['distance']) {
                    $fc->addDistance($data['user_city'], $data['distance']);
                }
                $fc->addGeo($data['country'], $data['region']);
                $fc->addLocation($data['user_city'], $data['location']);
                $fc->addRecommended($data['recommended']);
                $page = ($data['page']) ? $data['page'] : 1;
                $filteredArtists = $s->getFilteredArtists($oc, $fc, $page);
                $result[$category->getId()] = iterator_to_array($filteredArtists);
            }
        }

        if ($data['mainCategory']) {
            $data['categories'] = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('ActedLegalDocsBundle:Category')
                ->findByParent($data['mainCategory']);

            foreach ($data['categories'] as $category) {
                $fc = new FilterCriteria([$category]);
                if ($data['distance']) {
                    $fc->addDistance($data['user_city'], $data['distance']);
                }
                $fc->addGeo($data['country'], $data['region']);
                $fc->addLocation($data['user_city'], $data['location']);
                $page = ($data['page']) ? $data['page'] : 1;
                $filteredArtists = $s->getFilteredArtists($oc, $fc, $page);
                $result[$category->getId()] = iterator_to_array($filteredArtists);
            }
        }

        if (!$data['mainCategory'] && count($data['categories']) == 0) {
            $allMainCategory =  $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('ActedLegalDocsBundle:Category')
                ->findByParent(null);
            foreach ($allMainCategory as $mainCategory) {
                $data['categories'] = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('ActedLegalDocsBundle:Category')
                    ->findByParent($mainCategory->getId());
                $categoryIds = [];
                foreach ($data['categories'] as $category) {
                    $categoryIds[] = $category->getId();
                }
                $fc = new FilterCriteria($categoryIds, $data['with_video'], $data['query']);
                if ($data['distance']) {
                    $fc->addDistance($data['user_city'], $data['distance']);
                }
                $fc->addGeo($data['country'], $data['region']);
                $fc->addLocation($data['user_city'], $data['location']);
                $page = ($data['page']) ? $data['page'] : 1;
                $filteredArtists = $s->getFilteredArtists($oc, $fc, $page, $categoryIds);
                $result[$mainCategory->getId()] = iterator_to_array($filteredArtists);
            }
        }

        return $result;

    }
}
