<?php

/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 05.03.16
 * Time: 18:03
 */

namespace Acted\LegalDocsBundle\Form\DataTransformer;

use Acted\LegalDocsBundle\HttpFoundation\File\Base64File;
use Ratchet\Wamp\Exception;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Filesystem\Filesystem;

class Base64ToFileTransformer implements DataTransformerInterface
{

    /**
     * Transforms a value from the original representation to a transformed representation.
     *
     * @param mixed $value The value in the original representation
     *
     * @return mixed The value in the transformed representation
     *
     * @throws TransformationFailedException When the transformation fails.
     */
    public function transform($value)
    {
        if(is_null($value)) {
            return '';
        }

        return $value;
    }

    /**
     * Transforms a value from the transformed representation to its original
     * representation.
     *
     * @param mixed $value The value in the transformed representation
     *
     * @return mixed The value in the original representation
     *
     * @throws TransformationFailedException When the transformation fails.
     */
    public function reverseTransform($value)
    {
        if(empty($value)) {
            return null;
        }
        preg_match('/data:([^;]*);base64,(.*)/', $value, $matches);

        try {
            $file = new Base64File($value, $matches[1]);
        } catch (\Exception $e) {
            return null;
        }
        return $file->move('images', $file->getBasename());
    }
}