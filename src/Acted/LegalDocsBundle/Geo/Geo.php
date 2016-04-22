<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 03.04.16
 * Time: 1:46
 */

namespace Acted\LegalDocsBundle\Geo;


interface Geo
{
    public function setLatitude($value);
    public function setLongitude($value);
}