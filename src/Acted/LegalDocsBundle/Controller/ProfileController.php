<?php

namespace Acted\LegalDocsBundle\Controller;

use Acted\LegalDocsBundle\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileController extends Controller
{
    public function showAction($slug)
    {

        $em = $this->getDoctrine()->getManager();

        $artist = $em->getRepository('ActedLegalDocsBundle:Artist')->findOneBySlug($slug);

        if(!$artist) {
            throw new NotFoundHttpException();
        }

        return $this->render('ActedLegalDocsBundle:Profile:show.html.twig', array(
            'artist' => $artist,
        ));
    }

    public function listAction()
    {
        $entities = $this->getDoctrine()->getManager()->getRepository('ActedLegalDocsBundle:Artist')->findAll();

        return $this->render('ActedLegalDocsBundle:Profile:list.html.twig', array('entities' => $entities));

    }

}
