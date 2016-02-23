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
     * @var string
     *
     * @ORM\Column(name="event_amount", type="decimal", precision=9, scale=2)
     */
    private $event_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=255)
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="deposit_amount", type="decimal", precision=9, scale=2)
     */
    private $deposit_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="deposit_percent", type="decimal", precision=5, scale=2)
     */
    private $deposit_percent;

    /**
     * @var string
     *
     * @ORM\Column(name="balance_amount", type="decimal", precision=9, scale=2)
     */
    private $balance_amount;

    /**
     * @var string
     *
     * @ORM\Column(name="balance_percent", type="decimal", precision=5, scale=2)
     */
    private $balance_percent;

    /**
     * @var string
     *
     * @ORM\Column(name="balance_mode", type="string", length=255)
     */
    private $balance_mode;

    /**
     * @var string
     *
     * @ORM\Column(name="balance_when", type="string", length=255)
     */
    private $balance_when;

    /**
     * @var string
     *
     * @ORM\Column(name="transportation", type="string", length=255)
     */
    private $transportation;

    /**
     * @var string
     *
     * @ORM\Column(name="accomodation", type="string", length=255)
     */
    private $accomodation;

    /**
     * @var string
     *
     * @ORM\Column(name="special_terms", type="text")
     */
    private $special_terms;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_call_date", type="date")
     */
    private $last_call_date;

    /**
     * @var string
     *
     * @ORM\Column(name="artist_name", type="string", length=255)
     */
    private $artist_name;

    /**
     * @var string
     *
     * @ORM\Column(name="client_name", type="string", length=255)
     */
    private $client_name;

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

    /**
     * Set eventAmount
     *
     * @param string $eventAmount
     *
     * @return PerformanceContract
     */
    public function setEventAmount($eventAmount)
    {
        $this->event_amount = $eventAmount;

        return $this;
    }

    /**
     * Get eventAmount
     *
     * @return string
     */
    public function getEventAmount()
    {
        return $this->event_amount;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return PerformanceContract
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set depositAmount
     *
     * @param string $depositAmount
     *
     * @return PerformanceContract
     */
    public function setDepositAmount($depositAmount)
    {
        $this->deposit_amount = $depositAmount;

        return $this;
    }

    /**
     * Get depositAmount
     *
     * @return string
     */
    public function getDepositAmount()
    {
        return $this->deposit_amount;
    }

    /**
     * Set depositPercent
     *
     * @param string $depositPercent
     *
     * @return PerformanceContract
     */
    public function setDepositPercent($depositPercent)
    {
        $this->deposit_percent = $depositPercent;

        return $this;
    }

    /**
     * Get depositPercent
     *
     * @return string
     */
    public function getDepositPercent()
    {
        return $this->deposit_percent;
    }

    /**
     * Set balanceAmount
     *
     * @param string $balanceAmount
     *
     * @return PerformanceContract
     */
    public function setBalanceAmount($balanceAmount)
    {
        $this->balance_amount = $balanceAmount;

        return $this;
    }

    /**
     * Get balanceAmount
     *
     * @return string
     */
    public function getBalanceAmount()
    {
        return $this->balance_amount;
    }

    /**
     * Set balancePercent
     *
     * @param string $balancePercent
     *
     * @return PerformanceContract
     */
    public function setBalancePercent($balancePercent)
    {
        $this->balance_percent = $balancePercent;

        return $this;
    }

    /**
     * Get balancePercent
     *
     * @return string
     */
    public function getBalancePercent()
    {
        return $this->balance_percent;
    }

    /**
     * Set balanceMode
     *
     * @param string $balanceMode
     *
     * @return PerformanceContract
     */
    public function setBalanceMode($balanceMode)
    {
        $this->balance_mode = $balanceMode;

        return $this;
    }

    /**
     * Get balanceMode
     *
     * @return string
     */
    public function getBalanceMode()
    {
        return $this->balance_mode;
    }

    /**
     * Set balanceWhen
     *
     * @param string $balanceWhen
     *
     * @return PerformanceContract
     */
    public function setBalanceWhen($balanceWhen)
    {
        $this->balance_when = $balanceWhen;

        return $this;
    }

    /**
     * Get balanceWhen
     *
     * @return string
     */
    public function getBalanceWhen()
    {
        return $this->balance_when;
    }

    /**
     * Set transportation
     *
     * @param string $transportation
     *
     * @return PerformanceContract
     */
    public function setTransportation($transportation)
    {
        $this->transportation = $transportation;

        return $this;
    }

    /**
     * Get transportation
     *
     * @return string
     */
    public function getTransportation()
    {
        return $this->transportation;
    }

    /**
     * Set accomodation
     *
     * @param string $accomodation
     *
     * @return PerformanceContract
     */
    public function setAccomodation($accomodation)
    {
        $this->accomodation = $accomodation;

        return $this;
    }

    /**
     * Get accomodation
     *
     * @return string
     */
    public function getAccomodation()
    {
        return $this->accomodation;
    }

    /**
     * Set specialTerms
     *
     * @param string $specialTerms
     *
     * @return PerformanceContract
     */
    public function setSpecialTerms($specialTerms)
    {
        $this->special_terms = $specialTerms;

        return $this;
    }

    /**
     * Get specialTerms
     *
     * @return string
     */
    public function getSpecialTerms()
    {
        return $this->special_terms;
    }

    /**
     * Set lastCallDate
     *
     * @param \DateTime $lastCallDate
     *
     * @return PerformanceContract
     */
    public function setLastCallDate($lastCallDate)
    {
        $this->last_call_date = $lastCallDate;

        return $this;
    }

    /**
     * Get lastCallDate
     *
     * @return \DateTime
     */
    public function getLastCallDate()
    {
        return $this->last_call_date;
    }

    /**
     * Set artistName
     *
     * @param string $artistName
     *
     * @return PerformanceContract
     */
    public function setArtistName($artistName)
    {
        $this->artist_name = $artistName;

        return $this;
    }

    /**
     * Get artistName
     *
     * @return string
     */
    public function getArtistName()
    {
        return $this->artist_name;
    }

    /**
     * Set clientName
     *
     * @param string $clientName
     *
     * @return PerformanceContract
     */
    public function setClientName($clientName)
    {
        $this->client_name = $clientName;

        return $this;
    }

    /**
     * Get clientName
     *
     * @return string
     */
    public function getClientName()
    {
        return $this->client_name;
    }
}
