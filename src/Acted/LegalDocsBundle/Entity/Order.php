<?php

namespace Acted\LegalDocsBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
/**
 * Order
 */
class Order
{
    const STATUS_NEW = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_BOOKED = 2;

    const STATUS_CANCELED = 10;


    const FIELD_DETAILS = 1;
    const FIELD_TIMING = 2;
    const FIELD_TECHNICAL_REQUIREMENTS = 3;
    const FIELD_ACTS_EXTRAS = 4;

    /**
     * @var integer
     */
    private $id;


    /**
     * @Gedmo\Timestampable(on="create")
     * @var \DateTime
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @var \DateTime
     */
    private $updated;

    /**
     * @var int
     */
    private $status;

    /**
     * @var float
     */
    private $total_price;

    /**
     * @var \DateTime
     */
    private $payment_expiration_date;

    /**
     * @var float
     */
    private $deposit_amount;

    /**
     * @var float
     */
    private $deposit_ballance;

    /**
     * @var array
     */
    private $actor_details;

    /**
     * @var array
     */
    private $client_details;

    /**
     * @var string
     */
    private $performance_start_time;

    /**
     * @var string
     */
    private $additional_info;

    /**
     * @var array
     */
    private $technical_requirements;

    /**
     * @var integer
     */
    private $guaranteed_deposit_term;

    /**
     * @var integer
     */
    private $guaranteed_balance_term;

    /**
     * @var boolean
     */
    private $detailsAccepted;

    /**
     * @var boolean
     */
    private $actsExtrasAccepted;

    /**
     * @var boolean
     */
    private $timingAccepted;

    /**
     * @var boolean
     */
    private $technicalRequirementsAccepted;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $items;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $performances;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $services;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Client
     */
    private $client;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Artist
     */
    private $artist;

    /**
     * @var \Acted\LegalDocsBundle\Entity\RefCurrency
     */
    private $currency;

    /**
     * @var \Acted\LegalDocsBundle\Entity\ChatRoom
     */
    private $chat;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Order
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set id
     *
     * @param string $id
     *
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set generator
     *
     * @param string $generator
     *
     * @return Order
     */
    public function setGenerator($generator)
    {
        $this->generator = $generator;

        return $this;
    }

    /**
     * Get generator
     *
     * @return string
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Order
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Order
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set status
     *
     * @param int $status
     *
     * @return Order
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set totalPrice
     *
     * @param float $totalPrice
     *
     * @return Order
     */
    public function setTotalPrice($totalPrice)
    {
        $this->total_price = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->total_price;
    }

    /**
     * Set paymentExpirationDate
     *
     * @param \DateTime $paymentExpirationDate
     *
     * @return Order
     */
    public function setPaymentExpirationDate($paymentExpirationDate)
    {
        $this->payment_expiration_date = $paymentExpirationDate;

        return $this;
    }

    /**
     * Get paymentExpirationDate
     *
     * @return \DateTime
     */
    public function getPaymentExpirationDate()
    {
        return $this->payment_expiration_date;
    }

    /**
     * Set depositAmount
     *
     * @param float $depositAmount
     *
     * @return Order
     */
    public function setDepositAmount($depositAmount)
    {
        $this->deposit_amount = $depositAmount;

        return $this;
    }

    /**
     * Get depositAmount
     *
     * @return float
     */
    public function getDepositAmount()
    {
        return $this->deposit_amount;
    }

    /**
     * Set depositBallance
     *
     * @param float $depositBallance
     *
     * @return Order
     */
    public function setDepositBallance($depositBallance)
    {
        $this->deposit_ballance = $depositBallance;

        return $this;
    }

    /**
     * Get depositBallance
     *
     * @return float
     */
    public function getDepositBallance()
    {
        return $this->deposit_ballance;
    }

    /**
     * Set actorDetails
     *
     * @param array $actorDetails
     *
     * @return Order
     */
    public function setActorDetails($actorDetails)
    {
        $this->actor_details = $actorDetails;

        return $this;
    }

    /**
     * Get actorDetails
     *
     * @return array
     */
    public function getActorDetails()
    {
        return $this->actor_details;
    }

    /**
     * Set clientDetails
     *
     * @param array $clientDetails
     *
     * @return Order
     */
    public function setClientDetails($clientDetails)
    {
        $this->client_details = $clientDetails;

        return $this;
    }

    /**
     * Get clientDetails
     *
     * @return array
     */
    public function getClientDetails()
    {
        return $this->client_details;
    }

    /**
     * Set performanceStartTime
     *
     * @param string $performanceStartTime
     *
     * @return Order
     */
    public function setPerformanceStartTime($performanceStartTime)
    {
        $this->performance_start_time = $performanceStartTime;

        return $this;
    }

    /**
     * Get performanceStartTime
     *
     * @return string
     */
    public function getPerformanceStartTime()
    {
        return $this->performance_start_time;
    }

    /**
     * Set additionalInfo
     *
     * @param string $additionalInfo
     *
     * @return Order
     */
    public function setAdditionalInfo($additionalInfo)
    {
        $this->additional_info = $additionalInfo;

        return $this;
    }

    /**
     * Get additionalInfo
     *
     * @return string
     */
    public function getAdditionalInfo()
    {
        return $this->additional_info;
    }

    /**
     * Set technicalRequirements
     *
     * @param array $technicalRequirements
     *
     * @return Order
     */
    public function setTechnicalRequirements($technicalRequirements)
    {
        $this->technical_requirements = $technicalRequirements;

        return $this;
    }

    /**
     * Get technicalRequirements
     *
     * @return array
     */
    public function getTechnicalRequirements()
    {
        return $this->technical_requirements;
    }

    /**
     * Set guaranteedDepositTerm
     *
     * @param integer $guaranteedDepositTerm
     *
     * @return Order
     */
    public function setGuaranteedDepositTerm($guaranteedDepositTerm)
    {
        $this->guaranteed_deposit_term = $guaranteedDepositTerm;

        return $this;
    }

    /**
     * Get guaranteedDepositTerm
     *
     * @return integer
     */
    public function getGuaranteedDepositTerm()
    {
        return $this->guaranteed_deposit_term;
    }

    /**
     * Set guaranteedBalanceTerm
     *
     * @param integer $guaranteedBalanceTerm
     *
     * @return Order
     */
    public function setGuaranteedBalanceTerm($guaranteedBalanceTerm)
    {
        $this->guaranteed_balance_term = $guaranteedBalanceTerm;

        return $this;
    }

    /**
     * Get guaranteedBalanceTerm
     *
     * @return integer
     */
    public function getGuaranteedBalanceTerm()
    {
        return $this->guaranteed_balance_term;
    }

    /**
     * Set detailsAccepted
     *
     * @param boolean $detailsAccepted
     *
     * @return Order
     */
    public function setDetailsAccepted($detailsAccepted)
    {
        $this->detailsAccepted = $detailsAccepted;

        return $this;
    }

    /**
     * Get detailsAccepted
     *
     * @return boolean
     */
    public function getDetailsAccepted()
    {
        return $this->detailsAccepted;
    }

    /**
     * Set actsExtrasAccepted
     *
     * @param boolean $actsExtrasAccepted
     *
     * @return Order
     */
    public function setActsExtrasAccepted($actsExtrasAccepted)
    {
        $this->actsExtrasAccepted = $actsExtrasAccepted;

        return $this;
    }

    /**
     * Get actsExtrasAccepted
     *
     * @return boolean
     */
    public function getActsExtrasAccepted()
    {
        return $this->actsExtrasAccepted;
    }

    /**
     * Set timingAccepted
     *
     * @param boolean $timingAccepted
     *
     * @return Order
     */
    public function setTimingAccepted($timingAccepted)
    {
        $this->timingAccepted = $timingAccepted;

        return $this;
    }

    /**
     * Get timingAccepted
     *
     * @return boolean
     */
    public function getTimingAccepted()
    {
        return $this->timingAccepted;
    }

    /**
     * Set technicalRequirementsAccepted
     *
     * @param boolean $technicalRequirementsAccepted
     *
     * @return Order
     */
    public function setTechnicalRequirementsAccepted($technicalRequirementsAccepted)
    {
        $this->technicalRequirementsAccepted = $technicalRequirementsAccepted;

        return $this;
    }

    /**
     * Get technicalRequirementsAccepted
     *
     * @return boolean
     */
    public function getTechnicalRequirementsAccepted()
    {
        return $this->technicalRequirementsAccepted;
    }

    /**
     * Add item
     *
     * @param \Acted\LegalDocsBundle\Entity\OrderItem $item
     *
     * @return Order
     */
    public function addItem(\Acted\LegalDocsBundle\Entity\OrderItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \Acted\LegalDocsBundle\Entity\OrderItem $item
     */
    public function removeItem(\Acted\LegalDocsBundle\Entity\OrderItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add item
     *
     * @param \Acted\LegalDocsBundle\Entity\OrderItemPerformance $item
     *
     * @return Order
     */
    public function addPerformance(\Acted\LegalDocsBundle\Entity\OrderItemPerformance $item)
    {
        $this->performances[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \Acted\LegalDocsBundle\Entity\OrderItemPerformance $item
     */
    public function removePerformance(\Acted\LegalDocsBundle\Entity\OrderItemPerformance $item)
    {
        $this->performances->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerformances()
    {
        return $this->performances;
    }

    /**
     * Add item
     *
     * @param \Acted\LegalDocsBundle\Entity\OrderItemService $item
     *
     * @return Order
     */
    public function addService(\Acted\LegalDocsBundle\Entity\OrderItemService $item)
    {
        $this->services[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \Acted\LegalDocsBundle\Entity\OrderItemService $item
     */
    public function removeService(\Acted\LegalDocsBundle\Entity\OrderItemService $item)
    {
        $this->services->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * Set event
     *
     * @param \Acted\LegalDocsBundle\Entity\Event $event
     *
     * @return Order
     */
    public function setEvent(\Acted\LegalDocsBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Acted\LegalDocsBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set client
     *
     * @param \Acted\LegalDocsBundle\Entity\Client $client
     *
     * @return Order
     */
    public function setClient(\Acted\LegalDocsBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Acted\LegalDocsBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set artist
     *
     * @param \Acted\LegalDocsBundle\Entity\Artist $artist
     *
     * @return Order
     */
    public function setArtist(\Acted\LegalDocsBundle\Entity\Artist $artist = null)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist
     *
     * @return \Acted\LegalDocsBundle\Entity\Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set currency
     *
     * @param \Acted\LegalDocsBundle\Entity\RefCurrency $currency
     *
     * @return Order
     */
    public function setCurrency(\Acted\LegalDocsBundle\Entity\RefCurrency $currency = null)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \Acted\LegalDocsBundle\Entity\RefCurrency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return Order
     */
    public function getChat()
    {
        return $this->chat;
    }

    /**
     * @param Order $order
     */
    public function setChat(\Acted\LegalDocsBundle\Entity\Order $chat)
    {
        $this->chat = $chat;
    }




    public function getTimeFromAdd(){
        return $this->getCreated()->diff(new \DateTime())->format("%m month, %d days, %H, %M");
    }

    public function getDepositToPay(){
        return $this->getTotalPrice() * ($this->getGuaranteedDepositTerm() / 100);
    }

    public function getBalanceToPay(){
        return $this->getTotalPrice() * ($this->getGuaranteedBalanceTerm() / 100);
    }


}
