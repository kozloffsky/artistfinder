<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 22.03.16
 * Time: 15:36
 * @see https://gist.github.com/Graceas/6505663
 */

namespace Acted\LegalDocsBundle\FormErrors;

use Symfony\Component\Form\Form;

class FormErrorsSerializer
{

    public function serializeFormErrors(Form $form, $flat_array = false, $add_form_name = false, $glue_keys = '_')
    {
        $errors = $this->serialize($form);

        if ($flat_array) {
            $errors = $this->arrayFlatten($errors,
                $glue_keys, (($add_form_name) ? $form->getName() : ''));
        }


        return $errors;
    }

    private function serialize(Form $form)
    {
        $local_errors = [];
        foreach ($form->getIterator() as $key => $child) {

            foreach ($child->getErrors() as $error){
                $local_errors[$key] = $error->getMessage();
            }

            if (count($child->getIterator()) > 0) {
                $local_errors[$key] = $this->serialize($child);
            }
        }

        return $local_errors;
    }

    private function arrayFlatten($array, $separator = "_", $flattened_key = '') {
        $flattenedArray = [];
        foreach ($array as $key => $value) {

            if(is_array($value)) {

                $flattenedArray = array_merge($flattenedArray,
                    $this->arrayFlatten($value, $separator,
                        (strlen($flattened_key) > 0 ? $flattened_key . $separator : "") . $key)
                );

            } else {
                $flattenedArray[(strlen($flattened_key) > 0 ? $flattened_key . $separator : "") . $key] = $value;
            }
        }
        return $flattenedArray;
    }

}
