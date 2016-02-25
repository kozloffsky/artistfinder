<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefEventType
 */
class RefEventType
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
    private $eventTypeId;

    /**
     * @var varchar
     */
    private $eventType;


    /**
     * Set eventTypeId
     *
     * @param \int $eventTypeId
     *
     * @return RefEventType
     */
    public function setEventTypeId(\int $eventTypeId)
    {
        $this->eventTypeId = $eventTypeId;

        return $this;
    }

    /**
     * Get eventTypeId
     *
     * @return \int
     */
    public function getEventTypeId()
    {
        return $this->eventTypeId;
    }

    /**
     * Set eventType
     *
     * @param \varchar $eventType
     *
     * @return RefEventType
     */
    public function setEventType(\varchar $eventType)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return \varchar
     */
    public function getEventType()
    {
        return $this->eventType;
    }
}
