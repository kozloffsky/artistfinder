<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefEventType
 */
class RefEventType
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $eventType;

    public function __toString()
    {
        return $this->getEventType();
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
     * Set eventType
     *
     * @param string $eventType
     *
     * @return RefEventType
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return string
     */
    public function getEventType()
    {
        return $this->eventType;
    }
}
