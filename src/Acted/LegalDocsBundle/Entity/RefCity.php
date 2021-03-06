<?php

namespace Acted\LegalDocsBundle\Entity;
use Acted\LegalDocsBundle\Geo\Geo;

/**
 * RefCity
 */
class RefCity implements Geo
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $countryId;

    /**
     * @var string
     */
    private $placeId;

    public function __toString()
    {
        return $this->getName();
    }
    
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return RefCity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     *
     * @return RefCity
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return integer
     */
    public function getCountryId()
    {
        return $this->countryId;
    }
    /**
     * @var string
     */
    private $latitude;

    /**
     * @var string
     */
    private $longitude;


    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return RefCity
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return RefCity
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
    /**
     * @var \Acted\LegalDocsBundle\Entity\RefRegion
     */
    private $region;


    /**
     * Set region
     *
     * @param \Acted\LegalDocsBundle\Entity\RefRegion $region
     *
     * @return RefCity
     */
    public function setRegion(\Acted\LegalDocsBundle\Entity\RefRegion $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Acted\LegalDocsBundle\Entity\RefRegion
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set placeId
     *
     * @param string $placeId
     *
     * @return RefCity
     */
    public function setPlaceId($placeId)
    {
        $this->placeId = $placeId;

        return $this;
    }

    /**
     * Get placeId
     *
     * @return string
     */
    public function getPlaceId()
    {
        return $this->placeId;
    }
}
