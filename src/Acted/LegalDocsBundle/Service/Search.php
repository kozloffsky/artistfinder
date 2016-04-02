<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 02.04.16
 * Time: 17:03
 */

namespace Acted\LegalDocsBundle\Service;


use Acted\LegalDocsBundle\Search\OrderCriteria;

interface Search
{
    public function getFilteredArtists(OrderCriteria $oc);
}