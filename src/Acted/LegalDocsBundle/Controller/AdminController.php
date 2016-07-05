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

        $artistsQuery = $artistRepo->getArtistsList($query, $start, $end, false, false, null);
        $data = $paginator->paginate($artistsQuery, $page, 10);

        $artists = $serializer->toArray($data->getItems(), SerializationContext::create()
            ->setGroups(['recommend_artist']));
        $paginations = $data->getPaginationData();

        return $this->render('ActedLegalDocsBundle:Admin:recommend.html.twig',
           compact('artists', 'paginations')
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
        $start = $request->get('start');
        $end = $request->get('end');

        $artistsQuery = $artistRepo->getArtistsList($query, $start, $end, false, false, null);
        $data = $paginator->paginate($artistsQuery, $page, 10);

        $artists = $serializer->toArray($data->getItems(), SerializationContext::create()
            ->setGroups(['spotlight_artist']));
        $paginations = $data->getPaginationData();

        return $this->render('ActedLegalDocsBundle:Admin:spotlight.html.twig',
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
            $curArtist->setSpotlight(null);
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
