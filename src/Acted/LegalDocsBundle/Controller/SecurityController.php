<?php

namespace Acted\LegalDocsBundle\Controller;


class SecurityController extends Controller
{
    public function loginAction($name)
    {
        $helper = $this->get('security.authentication_utils');
        return $this->render('', array('name' => $name));
    }
}
