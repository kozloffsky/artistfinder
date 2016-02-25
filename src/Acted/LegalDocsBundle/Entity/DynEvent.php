<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynEvent
 */
class DynEvent
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
     * @var integer
     */
    private $eventId;

    /**
     * @var varchar
     */
    private $eventRef;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var varchar
     */
    private $title;

    /**
     * @var varchar
     */
    private $description;

    /**
     * @var int
     */
    private $eventTypeId;

    /**
     * @var boolean
     */
    private $isInternational;

    /**
     * @var varchar
     */
    private $address;

    /**
     * @var int
     */
    private $cityId;

    /**
     * @var double
     */
    private $budget;

    /**
     * @var int
     */
    private $currencyId;

    /**
     * @var \DateTime
     */
    private $startingDate;

    /**
     * @var \DateTime
     */
    private $endingDate;

    /**
     * @var varchar
     */
    private $timing;

    /**
     * @var varchar
     */
    private $comments;


    /**
     * Set eventId
     *
     * @param integer $eventId
     *
     * @return DynEvent
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Get eventId
     *
     * @return integer
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Set eventRef
     *
     * @param \varchar $eventRef
     *
     * @return DynEvent
     */
    public function setEventRef(\varchar $eventRef)
    {
        $this->eventRef = $eventRef;

        return $this;
    }

    /**
     * Get eventRef
     *
     * @return \varchar
     */
    public function getEventRef()
    {
        return $this->eventRef;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return DynEvent
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set title
     *
     * @param \varchar $title
     *
     * @return DynEvent
     */
    public function setTitle(\varchar $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return \varchar
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param \varchar $description
     *
     * @return DynEvent
     */
    public function setDescription(\varchar $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return \varchar
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set eventTypeId
     *
     * @param \int $eventTypeId
     *
     * @return DynEvent
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
     * Set isInternational
     *
     * @param boolean $isInternational
     *
     * @return DynEvent
     */
    public function setIsInternational($isInternational)
    {
        $this->isInternational = $isInternational;

        return $this;
    }

    /**
     * Get isInternational
     *
     * @return boolean
     */
    public function getIsInternational()
    {
        return $this->isInternational;
    }

    /**
     * Set address
     *
     * @param \varchar $address
     *
     * @return DynEvent
     */
    public function setAddress(\varchar $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \varchar
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set cityId
     *
     * @param \int $cityId
     *
     * @return DynEvent
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
     * Set budget
     *
     * @param \double $budget
     *
     * @return DynEvent
     */
    public function setBudget(\double $budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return \double
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set currencyId
     *
     * @param \int $currencyId
     *
     * @return DynEvent
     */
    public function setCurrencyId(\int $currencyId)
    {
        $this->currencyId = $currencyId;

        return $this;
    }

    /**
     * Get currencyId
     *
     * @return \int
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    /**
     * Set startingDate
     *
     * @param \DateTime $startingDate
     *
     * @return DynEvent
     */
    public function setStartingDate($startingDate)
    {
        $this->startingDate = $startingDate;

        return $this;
    }

    /**
     * Get startingDate
     *
     * @return \DateTime
     */
    public function getStartingDate()
    {
        return $this->startingDate;
    }

    /**
     * Set endingDate
     *
     * @param \DateTime $endingDate
     *
     * @return DynEvent
     */
    public function setEndingDate($endingDate)
    {
        $this->endingDate = $endingDate;

        return $this;
    }

    /**
     * Get endingDate
     *
     * @return \DateTime
     */
    public function getEndingDate()
    {
        return $this->endingDate;
    }

    /**
     * Set timing
     *
     * @param \varchar $timing
     *
     * @return DynEvent
     */
    public function setTiming(\varchar $timing)
    {
        $this->timing = $timing;

        return $this;
    }

    /**
     * Get timing
     *
     * @return \varchar
     */
    public function getTiming()
    {
        return $this->timing;
    }

    /**
     * Set comments
     *
     * @param \varchar $comments
     *
     * @return DynEvent
     */
    public function setComments(\varchar $comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return \varchar
     */
    public function getComments()
    {
        return $this->comments;
    }
}
