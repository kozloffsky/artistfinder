<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 03.04.16
 * Time: 1:08
 */

namespace Acted\LegalDocsBundle\Search;


class FilterCriteria
{
    protected $withVideo = false;

    public function __construct($withVideo = false)
    {
        $this->withVideo = (bool)$withVideo;
    }

    public function withVideo()
    {
        return $this->withVideo;
    }
}
