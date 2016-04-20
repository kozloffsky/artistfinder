<?php
/**
 * Created by PhpStorm.
 * User: dexm1
 * Date: 03.04.16
 * Time: 1:08
 */

namespace Acted\LegalDocsBundle\Search;


use Acted\LegalDocsBundle\Entity\RefCountry;
use Acted\LegalDocsBundle\Entity\RefRegion;

class FilterCriteria
{
    const DISTANCE_0_50 = 50;
    const DISTANCE_50_200 = 200;
    const DISTANCE_200_1000 = 1000;

    const LOCATION_100_KM = '100-km';
    const LOCATION_SAME_COUNTRY = 'same-country';
    const LOCATION_INTERNATIONAL = 'international';

    protected $withVideo = false;
    protected $categories = [];
    protected $query = null;
    protected $latitude;
    protected $longitude;
    protected $distance;
    protected $region;
    protected $country;
    protected $location;
    /** @var RefRegion */
    protected $userRegion;
    protected $recommended;

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

    public function addGeo(RefCountry $country = null, RefRegion $region = null)
    {
        $this->region = $region;
        $this->country = $country;
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

    public function getRegion()
    {
        return $this->region;
    }

    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    public function addLocation(RefRegion $region = null, $location)
    {
        $this->location = $location;
        $this->userRegion = $region;
        if ($region) {
            $this->latitude = $region->getLatitude();
            $this->longitude = $region->getLongitude();
        }
    }

    public function getUserRegion()
    {
        return $this->userRegion;
    }

    /**
     * @return mixed
     */
    public function getRecommended()
    {
        return $this->recommended;
    }

    /**
     * @param mixed $recommended
     */
    public function addRecommended($recommended)
    {
        $this->recommended = $recommended;
    }

}
