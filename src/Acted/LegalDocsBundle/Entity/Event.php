<?php

namespace Acted\LegalDocsBundle\Entity;

use Acted\LegalDocsBundle\Entity\RefVenueType;
use Acted\LegalDocsBundle\Entity\RefEventType;
use Faker\Provider\cs_CZ\DateTime;

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
     * @var RefEventType
     */
    private $eventType;

    /**
     * @var RefVenueType
     */
    private $venueType;

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
     * @var string
     */
    private $numberOfGuests;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $eventArtists;

    /**
     * @var integer
     */
    private $countDays;

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
     * Set eventType
     *
     * @param RefEventType $eventType
     *
     * @return Event
     */
    public function setEventType(RefEventType $eventType = null)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get eventType
     *
     * @return RefEventType
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set venueType
     *
     * @param RefVenueType $venueType
     *
     * @return Event
     */
    public function setVenueType(RefVenueType $venueType = null)
    {
        $this->venueType= $venueType;

        return $this;
    }

    /**
     * Get venueType
     *
     * @return RefVenueType
     */
    public function getVenueType()
    {
        return $this->venueType;
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

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $chatRooms;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->chatRooms = new \Doctrine\Common\Collections\ArrayCollection();
        $this->requestQuotations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add chatRoom
     *
     * @param \Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom
     *
     * @return Event
     */
    public function addChatRoom(\Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom)
    {
        $this->chatRooms[] = $chatRoom;

        return $this;
    }

    /**
     * Remove chatRoom
     *
     * @param \Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom
     */
    public function removeChatRoom(\Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom)
    {
        $this->chatRooms->removeElement($chatRoom);
    }

    /**
     * Get chatRooms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChatRooms()
    {
        return $this->chatRooms;
    }

    /**
     * @return Event
     */
    public function getNumberOfGuests()
    {
        return $this->numberOfGuests;
    }

    /**
     * @param string $numberOfGuests
     */
    public function setNumberOfGuests($numberOfGuests)
    {
        $this->numberOfGuests = $numberOfGuests;
    }

    public function getCountryId()
    {
        return ($this->city && $this->city->getRegion()->getCountry()) ? $this->city->getRegion()->getCountry()->getId
        () : null;
    }

    public function getCountryName()
    {
        return ($this->city && $this->city->getRegion()->getCountry()) ? $this->city->getRegion()->getCountry()->getName
        () : null;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $requestQuotations;


    /**
     * Add requestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\RequestQuotation $requestQuotation
     *
     * @return Event
     */
    public function addRequestQuotation(\Acted\LegalDocsBundle\Entity\RequestQuotation $requestQuotation)
    {
        $this->requestQuotations[] = $requestQuotation;

        return $this;
    }

    /**
     * Remove requestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\RequestQuotation $requestQuotation
     */
    public function removeRequestQuotation(\Acted\LegalDocsBundle\Entity\RequestQuotation $requestQuotation)
    {
        $this->requestQuotations->removeElement($requestQuotation);
    }

    /**
     * Get requestQuotations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRequestQuotations()
    {
        return $this->requestQuotations;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $feedbacks;


    /**
     * Add feedback
     *
     * @param \Acted\LegalDocsBundle\Entity\Feedback $feedback
     *
     * @return Event
     */
    public function addFeedback(\Acted\LegalDocsBundle\Entity\Feedback $feedback)
    {
        $this->feedbacks[] = $feedback;

        return $this;
    }

    /**
     * Remove feedback
     *
     * @param \Acted\LegalDocsBundle\Entity\Feedback $feedback
     */
    public function removeFeedback(\Acted\LegalDocsBundle\Entity\Feedback $feedback)
    {
        $this->feedbacks->removeElement($feedback);
    }

    /**
     * Get feedbacks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFeedbacks()
    {
        return $this->feedbacks;
    }

    /**
     * Add eventArtist
     *
     * @param \Acted\LegalDocsBundle\Entity\eventArtist $eventArtist
     *
     * @return Event
     */
    public function addEventArtist(\Acted\LegalDocsBundle\Entity\eventArtist $eventArtist)
    {
        $this->eventArtists[] = $eventArtist;

        return $this;
    }

    /**
     * Remove eventArtist
     *
     * @param \Acted\LegalDocsBundle\Entity\eventArtist $eventArtist
     */
    public function removeEventArtist(\Acted\LegalDocsBundle\Entity\eventArtist $eventArtist)
    {
        $this->eventArtists->removeElement($eventArtist);
    }

    /**
     * Get eventArtists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventArtists()
    {
        return $this->eventArtists;
    }

    /**
     * Set entity properties dynamically.
     *
     * @param array $option
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setOptions(array $options)
    {
        $_classMethods = get_class_methods($this);
        foreach ($options as $key => $value) {
            if(stripos($key, 'date') !== false){
                $value = \DateTime::createFromFormat('d/m/Y', $value);
            }

            if(stripos($key, 'venue') !== false){

            }

            $method = 'set' . ucfirst($key);
            if (in_array($method, $_classMethods)) {
                $this->$method($value);
            } else {
                throw new \Exception('Invalid method name');
            }
        }
        return $this;
    }

    /**
     * Set countDays
     *
     * @param integer $countDays
     *
     * @return Event
     */
    public function setCountDays($countDays)
    {
        $this->countDays = $countDays;

        return $this;
    }

    /**
     * Get countDays
     *
     * @return integer
     */
    public function getCountDays()
    {
        return $this->countDays;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $eventOffer;


    /**
     * Add eventOffer
     *
     * @param \Acted\LegalDocsBundle\Entity\EventOffer $eventOffer
     *
     * @return Event
     */
    public function addEventOffer(\Acted\LegalDocsBundle\Entity\EventOffer $eventOffer)
    {
        $this->eventOffer[] = $eventOffer;

        return $this;
    }

    /**
     * Remove eventOffer
     *
     * @param \Acted\LegalDocsBundle\Entity\EventOffer $eventOffer
     */
    public function removeEventOffer(\Acted\LegalDocsBundle\Entity\EventOffer $eventOffer)
    {
        $this->eventOffer->removeElement($eventOffer);
    }

    /**
     * Get eventOffer
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventOffer()
    {
        return $this->eventOffer;
    }
}
