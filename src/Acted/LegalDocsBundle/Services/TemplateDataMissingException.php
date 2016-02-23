<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acted\LegalDocsBundle\Services;

use Symfony\Component\HttpKernel\Exception\HttpException;
/**
 * TemplateDataMissingException.
 *
 * @author Alex Makhorin
 */
class TemplateDataMissingException extends HttpException
{

    public function __construct($variable)
    {
        parent::__construct(500, "'{$variable}' value was not set.", null, array(), 0);
    }
}
