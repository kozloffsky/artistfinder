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

        return $this->render('ActedLegalDocsBundle:Profile:showProfile.html.twig', array(
            'artist' => $artist,
        ));
    }

}
