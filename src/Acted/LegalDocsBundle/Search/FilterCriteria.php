<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 03.04.16
 * Time: 1:08
 */

namespace Acted\LegalDocsBundle\Search;


use Acted\LegalDocsBundle\Entity\RefRegion;

class FilterCriteria
{
    const DISTANCE_0_50 = 50;
    const DISTANCE_50_200 = 200;
    const DISTANCE_200_1000 = 1000;

    protected $withVideo = false;
    protected $categories = [];
    protected $query = null;
    protected $latitude;
    protected $longitude;
    protected $distance;

    public function __construct($categories = [], $withVideo = false, $query = null)
    {
        $this->withVideo = (bool)$withVideo;
        $this->categories = $categories;
        $this->query = $query;
    }

    public function addDistance(RefRegion $region, $distance)
    {
        $this->latitude = $region->getLatitude();
        $this->longitude = $region->getLongitude();
        $this->distance = $distance;
    }

    public function getUserLatitude()
    {
        return $this->latitude;
    }

    public function getUserLongitude()
    {
        return $this->longitude;
    }


    public function getMinDistance()
    {
        switch ($this->distance) {
            case self::DISTANCE_0_50:
                return 0;
            case self::DISTANCE_50_200:
                return 50;
            case self::DISTANCE_200_1000:
                return 200;
            default:
                return false;
        }
    }

    public function getMaxDistance()
    {
        switch ($this->distance) {
            case self::DISTANCE_0_50:
                return 50;
            case self::DISTANCE_50_200:
                return 200;
            case self::DISTANCE_200_1000:
                return 1000;
            default:
                return false;
        }
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
