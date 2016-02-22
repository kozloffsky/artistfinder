<?php

namespace Acted\LegalDocsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PerformanceContract
 *
 * @ORM\Table(name="PerformanceContract")
 * @ORM\Entity(repositoryClass="Acted\LegalDocsBundle\Repository\PerformanceContractRepository")
 */
class PerformanceContract
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="artist_address", type="string", length=255)
     */
    private $artist_address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="today_date", type="date")
     */
    private $today_date;

    /**
     * @var string
     *
     * @ORM\Column(name="artist_details", type="string", length=255)
     */
    private $artist_details;

    /**
     * @var string
     *
     * @ORM\Column(name="client_details", type="string", length=255)
     */
    private $client_details;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_date", type="date")
     */
    private $event_date;

    /**
     * @var string
     *
     * @ORM\Column(name="event_location", type="string", length=255)
     */
    private $event_location;

    /**
     * @var string
     *
     * @ORM\Column(name="performance_description", type="string", length=255)
     */
    private $performance_description;


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
     * Set artist_address
     *
     * @param string $artistAddress
     * @return PerformanceContract
     */
    public function setArtistAddress($artistAddress)
    {
        $this->artist_address = $artistAddress;

        return $this;
    }

    /**
     * Get artist_address
     *
     * @return string 
     */
    public function getArtistAddress()
    {
        return $this->artist_address;
    }

    /**
     * Set today_date
     *
     * @param \DateTime $todayDate
     * @return PerformanceContract
     */
    public function setTodayDate($todayDate)
    {
        $this->today_date = $todayDate;

        return $this;
    }

    /**
     * Get today_date
     *
     * @return \DateTime 
     */
    public function getTodayDate()
    {
        return $this->today_date;
    }

    /**
     * Set artist_details
     *
     * @param string $artistDetails
     * @return PerformanceContract
     */
    public function setArtistDetails($artistDetails)
    {
        $this->artist_details = $artistDetails;

        return $this;
    }

    /**
     * Get artist_details
     *
     * @return string 
     */
    public function getArtistDetails()
    {
        return $this->artist_details;
    }

    /**
     * Set client_details
     *
     * @param string $clientDetails
     * @return PerformanceContract
     */
    public function setClientDetails($clientDetails)
    {
        $this->client_details = $clientDetails;

        return $this;
    }

    /**
     * Get client_details
     *
     * @return string 
     */
    public function getClientDetails()
    {
        return $this->client_details;
    }

    /**
     * Set event_date
     *
     * @param \DateTime $eventDate
     * @return PerformanceContract
     */
    public function setEventDate($eventDate)
    {
        $this->event_date = $eventDate;

        return $this;
    }

    /**
     * Get event_date
     *
     * @return \DateTime 
     */
    public function getEventDate()
    {
        return $this->event_date;
    }

    /**
     * Set event_location
     *
     * @param string $eventLocation
     * @return PerformanceContract
     */
    public function setEventLocation($eventLocation)
    {
        $this->event_location = $eventLocation;

        return $this;
    }

    /**
     * Get event_location
     *
     * @return string 
     */
    public function getEventLocation()
    {
        return $this->event_location;
    }

    /**
     * Set performance_description
     *
     * @param string $performanceDescription
     * @return PerformanceContract
     */
    public function setPerformanceDescription($performanceDescription)
    {
        $this->performance_description = $performanceDescription;

        return $this;
    }

    /**
     * Get performance_description
     *
     * @return string 
     */
    public function getPerformanceDescription()
    {
        return $this->performance_description;
    }
}
