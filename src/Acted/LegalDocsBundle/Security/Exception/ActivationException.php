<?php

namespace Acted\LegalDocsBundle\Security\Exception;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 15.03.16
 * Time: 16:05
 */
class ActivationException extends AuthenticationException
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return 'You must confirm your email.';
    }
}
