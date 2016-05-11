<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefVenueType
 */
class RefVenueType
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $venueType;

    public function __toString()
    {
        return $this->getVenueType();
    }

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
     * Set venueType
     *
     * @param string $venueType
     *
     * @return RefVenueType
     */
    public function setVenueType($venueType)
    {
        $this->venueType = $venueType;

        return $this;
    }

    /**
     * Get venueType
     *
     * @return string
     */
    public function getVenueType()
    {
        return $this->venueType;
    }
}
