<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefCountry
 */
class RefCountry
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
    private $countryId;

    /**
     * @var varchar
     */
    private $name;


    /**
     * Set countryId
     *
     * @param \int $countryId
     *
     * @return RefCountry
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

    /**
     * Set name
     *
     * @param \varchar $name
     *
     * @return RefCountry
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
}
