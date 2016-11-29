<?php

namespace Acted\LegalDocsBundle\Popo;

final class EventOfferData
{
    private $name;
    private $eventDate;
    private $eventTime;
    private $type;
    private $country;
    private $city;
    private $location;
    private $venueType;
    private $numberOfGuests;
    private $comment;
    private $performance;
    private $offer;
    private $event;
    private $user;
    private $cityLat;
    private $cityLng;
    private $regionLat;
    private $regionLng;
    private $regionName;
    private $detailsAccepted;
    private $actsExtrasAccepted;
    private $timingAccepted;
    private $technicalRequirementsAccepted;

    const NUMBER_OF_GUEST_MAX_50 = 'less_then_50';
    const NUMBER_OF_GUEST_MIN_50_MAX_100 = '50-100';
    const NUMBER_OF_GUEST_MIN_100_MAX_500 = '100-500';
    const NUMBER_OF_GUEST_MORE_500 = '500+';

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * @param mixed $eventDate
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;
    }

    /**
     * @return mixed
     */
    public function getEventTime()
    {
        return $this->eventTime;
    }

    /**
     * @param mixed $eventTime
     */
    public function setEventTime($eventTime)
    {
        $this->eventTime = $eventTime;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getVenueType()
    {
        return $this->venueType;
    }

    /**
     * @param mixed $venueType
     */
    public function setVenueType($venueType)
    {
        $this->venueType = $venueType;
    }

    /**
     * @return mixed
     */
    public function getNumberOfGuests()
    {
        return $this->numberOfGuests;
    }

    /**
     * @param mixed $numberOfGuests
     */
    public function setNumberOfGuests($numberOfGuests)
    {
        $this->numberOfGuests = $numberOfGuests;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getPerformance()
    {
        return $this->performance;
    }

    /**
     * Get array performance Ids
     * @return array
     */
    public function getPerformanceIds()
    {
        $performances = $this->getPerformance();
        $result = [];
        if (!empty($performances)) {
            foreach ($performances as $performance) {
                $result[] = $performance->getId();
            }
        }

        return $result;
    }

    /**
     * @param mixed $performance
     */
    public function setPerformance($performance)
    {
        $this->performance = $performance;
    }

    /**
     * @return mixed
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * @param mixed $offer
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getCityLat()
    {
        return $this->cityLat;
    }

    /**
     * @param string $cityLat
     */
    public function setCityLat($cityLat)
    {
        $this->cityLat = $cityLat;
    }

    /**
     * @return string
     */
    public function getCityLng()
    {
        return $this->cityLng;
    }

    /**
     * @param string $cityLng
     */
    public function setCityLng($cityLng)
    {
        $this->cityLng = $cityLng;
    }

    /**
     * @return string
     */
    public function getRegionLat()
    {
        return $this->regionLat;
    }

    /**
     * @param string $regionLat
     */
    public function setRegionLat($regionLat)
    {
        $this->regionLat = $regionLat;
    }

    /**
     * @return string
     */
    public function getRegionLng()
    {
        return $this->regionLng;
    }

    /**
     * @param string $regionLng
     */
    public function setRegionLng($regionLng)
    {
        $this->regionLng = $regionLng;
    }

    /**
     * @return string
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * @param string $regionName
     */
    public function setRegionName($regionName)
    {
        $this->regionName = $regionName;
    }

    /**
     * @return boolean
     */
    public function getDetailsAccepted()
    {
        return $this->detailsAccepted;
    }

    /**
     * @param boolean $detailsAccepted
     */
    public function setDetailsAccepted($detailsAccepted)
    {
        $this->detailsAccepted = $detailsAccepted;
    }

    /**
     * @return boolean
     */
    public function getActsExtrasAccepted()
    {
        return $this->actsExtrasAccepted;
    }

    /**
     * @param boolean $actsExtrasAccepted
     */
    public function setActsExtrasAccepted($actsExtrasAccepted)
    {
        $this->actsExtrasAccepted = $actsExtrasAccepted;
    }

    /**
     * @return boolean
     */
    public function getTimingAccepted()
    {
        return $this->timingAccepted;
    }

    /**
     * @param boolean $timingAccepted
     */
    public function setTimingAccepted($timingAccepted)
    {
        $this->timingAccepted = $timingAccepted;
    }

    /**
     * @return boolean
     */
    public function getTechnicalRequirementsAccepted()
    {
        return $this->technicalRequirementsAccepted ;
    }

    /**
     * @param boolean $technicalRequirementsAccepted
     */
    public function setTechnicalRequirementsAccepted($technicalRequirementsAccepted)
    {
        $this->technicalRequirementsAccepted = $technicalRequirementsAccepted;
    }
    
}
