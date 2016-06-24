<?php

namespace Acted\LegalDocsBundle\Controller;

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

        $artistsQuery = $artistRepo->getArtistsList($query, $start, $end);
        $data = $paginator->paginate($artistsQuery, $page, 10);

        $artists = $serializer->toArray($data->getItems(), SerializationContext::create()
            ->setGroups(['recommend_artist']));
        $paginations = $data->getPaginationData();

        return $this->render('ActedLegalDocsBundle:Admin:index.html.twig',
           compact('artists', 'paginations')
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
        $artistId = $request->get('id');
        $recommend = json_decode($request->getContent())->recommend;
        if ($recommend > 100 && $recommend < 0 ) {
            return new JsonResponse(['error' => 'You should set only positive recommend value less or equal 100'], 400);
        }
        $artistRepo = $this->getEM()->getRepository('ActedLegalDocsBundle:Artist');
        $artists = $artistRepo->getArtistsList(null, $recommend, null, true)->getResult();
        $curArtist = $artistRepo->find($artistId);

        $curArtist->setRecommend($recommend);
        $this->getEM()->persist($curArtist);

        foreach ($artists as $artist) {
            $recommend++;
            if ($recommend < 101) {
                $artist->setRecommend($recommend);
            } else {
                $artist->setRecommend(0);
            }
            $this->getEM()->persist($artist);
        }

        $this->getEM()->flush();

        return new JsonResponse(['success' => 'Recommendation was changed!']);
    }
}
