<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefCity
 */
class RefCity
{
    /**
     * @var int
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var int
     */
    private $cityId;

    /**
     * @var varchar
     */
    private $name;

    /**
     * @var int
     */
    private $countryId;


    /**
     * Set cityId
     *
     * @param \int $cityId
     *
     * @return RefCity
     */
    public function setCityId(\int $cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return \int
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Set name
     *
     * @param \varchar $name
     *
     * @return RefCity
     */
    public function setName(\varchar $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return \varchar
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set countryId
     *
     * @param \int $countryId
     *
     * @return RefCity
     */
    public function setCountryId(\int $countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return \int
     */
    public function getCountryId()
    {
        return $this->countryId;
    }
}
