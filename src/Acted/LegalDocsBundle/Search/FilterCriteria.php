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
    protected $query = null;

    public function __construct($categories = [], $withVideo = false, $query = null)
    {
        $this->withVideo = (bool)$withVideo;
        $this->categories = $categories;
        $this->query = $query;
    }

    public function withVideo()
    {
        return $this->withVideo;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getQuery()
    {
        return $this->query;
    }
}
