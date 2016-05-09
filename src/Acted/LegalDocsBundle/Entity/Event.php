<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Event
 */
class Event
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $eventRef;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $eventTypeId;

    /**
     * @var integer
     */
    private $venueTypeId;

    /**
     * @var boolean
     */
    private $isInternational;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $cityId;

    /**
     * @var float
     */
    private $budget;

    /**
     * @var integer
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
     * @var string
     */
    private $timing;

    /**
     * @var string
     */
    private $comments;


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
     * Set eventRef
     *
     * @param string $eventRef
     *
     * @return Event
     */
    public function setEventRef($eventRef)
    {
        $this->eventRef = $eventRef;

        return $this;
    }

    /**
     * Get eventRef
     *
     * @return string
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
     * @return Event
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
     * @param string $title
     *
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set eventTypeId
     *
     * @param integer $eventTypeId
     *
     * @return Event
     */
    public function setEventTypeId($eventTypeId)
    {
        $this->eventTypeId = $eventTypeId;

        return $this;
    }

    /**
     * Get eventTypeId
     *
     * @return integer
     */
    public function getEventTypeId()
    {
        return $this->eventTypeId;
    }

    /**
     * Set venueTypeId
     *
     * @param integer $venueTypeId
     *
     * @return Event
     */
    public function setVenueTypeId($venueTypeId)
    {
        $this->venueTypeId = $venueTypeId;

        return $this;
    }

    /**
     * Get venueTypeId
     *
     * @return integer
     */
    public function getVenueTypeId()
    {
        return $this->venueTypeId;
    }

    /**
     * Set isInternational
     *
     * @param boolean $isInternational
     *
     * @return Event
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
     * @param string $address
     *
     * @return Event
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set cityId
     *
     * @param integer $cityId
     *
     * @return Event
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return integer
     */
    public function getCityId()
    {
        return $this->cityId;
    }

    /**
     * Set budget
     *
     * @param float $budget
     *
     * @return Event
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return float
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set currencyId
     *
     * @param integer $currencyId
     *
     * @return Event
     */
    public function setCurrencyId($currencyId)
    {
        $this->currencyId = $currencyId;

        return $this;
    }

    /**
     * Get currencyId
     *
     * @return integer
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
     * @return Event
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
     * @return Event
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
     * @param string $timing
     *
     * @return Event
     */
    public function setTiming($timing)
    {
        $this->timing = $timing;

        return $this;
    }

    /**
     * Get timing
     *
     * @return string
     */
    public function getTiming()
    {
        return $this->timing;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Event
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }
    /**
     * @var \Acted\LegalDocsBundle\Entity\User
     */
    private $user;

    /**
     * @var \Acted\LegalDocsBundle\Entity\RefCity
     */
    private $city;


    /**
     * Set user
     *
     * @param \Acted\LegalDocsBundle\Entity\User $user
     *
     * @return Event
     */
    public function setUser(\Acted\LegalDocsBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Acted\LegalDocsBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set city
     *
     * @param \Acted\LegalDocsBundle\Entity\RefCity $city
     *
     * @return Event
     */
    public function setCity(\Acted\LegalDocsBundle\Entity\RefCity $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Acted\LegalDocsBundle\Entity\RefCity
     */
    public function getCity()
    {
        return $this->city;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
