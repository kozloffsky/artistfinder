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
    protected $categories = [];

    public function __construct($categories = [], $withVideo = false)
    {
        $this->withVideo = (bool)$withVideo;
        $this->categories = $categories;
    }

    public function withVideo()
    {
        return $this->withVideo;
    }

    public function getCategories()
    {
        return $this->categories;
    }
}
