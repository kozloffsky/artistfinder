<?php

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $homespotlight = $em->getRepository('ActedLegalDocsBundle:Homespotlight')->findAll();
        $categories = $em->getRepository('ActedLegalDocsBundle:Category')->childrenHierarchy();

        return $this->render('ActedLegalDocsBundle:Default:index.html.twig',
            compact('homespotlight', 'categories'));
    }
}
