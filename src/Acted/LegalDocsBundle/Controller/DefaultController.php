<?php

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ActedLegalDocsBundle:Default:index.html.twig');
    }
}
