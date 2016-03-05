<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 05.03.16
 * Time: 16:16
 */

namespace Acted\LegalDocsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Symfony\Component\Form\Form;

class Controller extends BaseController
{
    protected function formErrorResponse(Form $form)
    {
        $errors = [];
        foreach ($form->getErrors(true, true) as $formError) {
            $errors[] = $formError->getMessage();
        }
        $data = [];
        $data['status'] = 'error';
        $data['errors'] = $errors;
        return $data;
    }
}