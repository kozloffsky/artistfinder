<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 22.04.16
 * Time: 11:40
 */

namespace Acted\LegalDocsBundle\Serializer;

use JMS\Serializer\Handler\ConstraintViolationHandler as BaseHandler;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Validator\ConstraintViolation;

class ConstraintViolationHandler extends BaseHandler
{
    public function serializeViolationToJson(JsonSerializationVisitor $visitor, ConstraintViolation $violation, array $type = null)
    {
        $data[$violation->getPropertyPath()] = $violation->getMessage();

        if (null === $visitor->getRoot()) {
            $visitor->setRoot($data);
        }

        return $data;
    }

}