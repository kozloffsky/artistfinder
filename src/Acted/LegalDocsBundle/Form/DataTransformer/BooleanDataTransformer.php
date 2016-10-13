<?php

namespace Acted\LegalDocsBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class BooleanDataTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return null;
    }

    public function reverseTransform($value)
    {
        if ($value === "false" || $value === "0" || $value === "" || $value === 0) {
            return false;
        }

        return true;
    }
}