<?php

namespace Acted\LegalDocsBundle\Entity;
use Acted\LegalDocsBundle\Geo\Geo;

/**
 * RefRegion
 */
class RefRegion implements Geo
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
     * @var \Acted\LegalDocsBundle\Entity\RefCountry
     */
    private $country;


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
     * @return RefRegion
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
     * Set country
     *
     * @param \Acted\LegalDocsBundle\Entity\RefCountry $country
     *
     * @return RefRegion
     */
    public function setCountry(\Acted\LegalDocsBundle\Entity\RefCountry $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Acted\LegalDocsBundle\Entity\RefCountry
     */
    public function getCountry()
    {
        return $this->country;
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
     * @return RefRegion
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
     * @return RefRegion
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
}
