<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Acted\LegalDocsBundle\Entity\Recommend;
use Acted\LegalDocsBundle\Form\RecommendType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class AdminController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function recommendAction(Request $request)
    {
        $page = $request->get('page');
        $artistRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:Artist');
        $serializer = $this->get('jms_serializer');
        $paginator  = $this->get('knp_paginator');
        $query = $request->get('query');
        $start = $request->get('start');
        $end = $request->get('end');
        $mainCat = $request->get('main');
        $filters = [
            'query' => $query,
            'start' => $start,
            'end' => $end,
            'main' => $mainCat
        ];
        $categories = $this->getEM()->getRepository('ActedLegalDocsBundle:Category')->getRecommended();
        if (!$mainCat) {
            $mainCat = $categories[0]->getId();
        }

        $artistsQuery = $artistRepo->getArtistsList($query, $start, $end, true, false, null, $mainCat);
        $data = $paginator->paginate($artistsQuery, $page, 30);

        $artists = $serializer->toArray($data->getItems(), SerializationContext::create()
            ->setGroups(['recommend_artist']));
        $paginations = $data->getPaginationData();

        return $this->render('ActedLegalDocsBundle:Admin:recommend.html.twig',
           compact('artists', 'paginations', 'filters', 'categories')
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function spotlightAction(Request $request)
    {
        $page = $request->get('page');
        $artistRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:Artist');
        $serializer = $this->get('jms_serializer');
        $paginator  = $this->get('knp_paginator');
        $query = $request->get('query');
        $start = empty($request->get('start')) ? $request->get('start'): 1;
        $end = $request->get('end');

        $filters = [
            'query' => $query,
            'start' => $start,
            'end' => $end
        ];

        $artistsQuery = $artistRepo->getArtistsList($query, $start, $end, false, true, null);
        $data = $paginator->paginate($artistsQuery, $page, 30);

        $artists = $serializer->toArray($data->getItems(), SerializationContext::create()
            ->setGroups(['spotlight_artist']));
        $paginations = $data->getPaginationData();

        return $this->render('ActedLegalDocsBundle:Admin:spotlight.html.twig',
            compact('artists', 'paginations', 'filters')
        );
    }

    /**
     * change recommend
     * @ApiDoc(
     *  description="Change Recommend",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when not exist offer",
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeRecommendValueAction(Request $request)
    {
        $form = $this->createForm(RecommendType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $recommendRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:Recommend');
            $artist = $recommendRepo->findOneBy(['artist' => $data->getArtist(), 'category' => $data->getCategory()]);
            if ($data->getValue() === 0 && $artist) {
                $this->getEM()->remove($artist);
                $this->getEM()->flush();

                return new JsonResponse(['success' => 'Recommendation was changed!']);
            }
            $recommends = $recommendRepo->findRecommendByData($data->getCategory(), $data->getArtist(),
                $data->getValue());

            if ($artist) {
                $artist->setValue($data->getValue());
            } else {
                $artist = new Recommend();
                $artist->setValue($data->getValue());
                $artist->setCategory($data->getCategory());
                $artist->setArtist($data->getArtist());
            }
            $this->getEM()->persist($artist);
            $this->getEM()->flush();
            $recommendData = $data->getValue();

            foreach ($recommends as $recommend) {
                $recommendData++;
                if ($recommendData < 101) {
                    $recommend->setValue($recommendData);
                    $this->getEM()->persist($recommend);
                } else {
                    $this->getEM()->remove($recommend);
                }
            }

            $this->getEM()->flush();
        } else {
            $errors = array();

            foreach ($form->getErrors(true) as $key => $error) {
                $errors[] = $error->getMessage();
            }

            return new JsonResponse(['error' => $errors], 400);
        }

        return new JsonResponse(['success' => 'Recommendation was changed!']);
    }

    /**
     * Change spotlight
     * @ApiDoc(
     *  description="Change Spotlight",
     *  statusCodes={
     *         200="Returned when successful",
     *         400="Returned when not exist offer",
     *     }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function changeSpotlightValueAction(Request $request)
    {
        $artistId = $request->get('id');

        $spotlight = $request->get('spotlight');
        if ($spotlight < 0 ) {
            return new JsonResponse(['error' => 'You should set only positive spotlight value'], 400);
        }
        $artistRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:Artist');

        $curArtist = $artistRepo->find($artistId);
        if ($spotlight === 0) {
            $curArtist->setSpotlight(0);
            $this->getEM()->persist($curArtist);
            $this->getEM()->flush();

            return new JsonResponse(['success' => 'Spotlight was changed!']);
        }
        $artists = $artistRepo->getArtistsList(null, $spotlight, null, false, true, $artistId)->getResult();


        $curArtist->setSpotlight($spotlight);
        $this->getEM()->persist($curArtist);
        foreach ($artists as $artist) {
            $spotlight++;
            $artist->setSpotlight($spotlight);
            $this->getEM()->persist($artist);
        }

        $this->getEM()->flush();

        return new JsonResponse(['success' => 'Spotlight was changed!']);
    }
}
