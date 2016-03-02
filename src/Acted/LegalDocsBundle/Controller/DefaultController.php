<?php

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        var_dump($_SERVER); die;
        return $this->render('ActedLegalDocsBundle:Default:index.html.twig');
    }
}
