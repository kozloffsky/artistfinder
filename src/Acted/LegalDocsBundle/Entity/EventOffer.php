<?php

namespace Acted\LegalDocsBundle\Entity;

use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Offer;

/**
 * EventOffer
 */
class EventOffer
{
    const EVENT_OFFER_STATUS_PROPOSE = 'propose';
    const EVENT_OFFER_STATUS_REJECT = 'reject';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var Event
     */
    private $event;

    /**
     * @var Offer
     */
    private $offer;

    /**
     * @var string
     */
    private $status;

    /**
     * @var float
     */
    private $price;

    /**
     * @var integer
     */
    private $currencyId;

    /**
     * @var float
     */
    private $depositValue;

    /**
     * @var string
     */
    private $depositType;

    /**
     * @var string
     */
    private $paymentTerms;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var \DateTime
     */
    private $sendDateTime;

    /**
     * @var \DateTime
     */
    private $readDateTime;

    /**
     * Get id
     *
     * @return Event
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set eventId
     *
     * @param Event $event
     *
     * @return EventOffer
     */
    public function setEvent(Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set offerId
     *
     * @param Offer $offer
     *
     * @return EventOffer
     */
    public function setOffer(Offer $offer = null)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return Offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return EventOffer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return EventOffer
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set currencyId
     *
     * @param integer $currencyId
     *
     * @return EventOffer
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
     * Set depositValue
     *
     * @param float $depositValue
     *
     * @return EventOffer
     */
    public function setDepositValue($depositValue)
    {
        $this->depositValue = $depositValue;

        return $this;
    }

    /**
     * Get depositValue
     *
     * @return float
     */
    public function getDepositValue()
    {
        return $this->depositValue;
    }

    /**
     * Set depositType
     *
     * @param string $depositType
     *
     * @return EventOffer
     */
    public function setDepositType($depositType)
    {
        $this->depositType = $depositType;

        return $this;
    }

    /**
     * Get depositType
     *
     * @return string
     */
    public function getDepositType()
    {
        return $this->depositType;
    }

    /**
     * Set paymentTerms
     *
     * @param string $paymentTerms
     *
     * @return EventOffer
     */
    public function setPaymentTerms($paymentTerms)
    {
        $this->paymentTerms = $paymentTerms;

        return $this;
    }

    /**
     * Get paymentTerms
     *
     * @return string
     */
    public function getPaymentTerms()
    {
        return $this->paymentTerms;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return EventOffer
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
     * Set sendDateTime
     *
     * @param \DateTime $sendDateTime
     *
     * @return EventOffer
     */
    public function setSendDateTime($sendDateTime)
    {
        $this->sendDateTime = $sendDateTime;

        return $this;
    }

    /**
     * Get sendDateTime
     *
     * @return \DateTime
     */
    public function getSendDateTime()
    {
        return $this->sendDateTime;
    }

    /**
     * Set readDateTime
     *
     * @param \DateTime $readDateTime
     *
     * @return EventOffer
     */
    public function setReadDateTime($readDateTime)
    {
        $this->readDateTime = $readDateTime;

        return $this;
    }

    /**
     * Get readDateTime
     *
     * @return \DateTime
     */
    public function getReadDateTime()
    {
        return $this->readDateTime;
    }

    public function getTimeFromAdd()
    {
        $now = new \DateTime();
        $period = $now->diff($this->getSendDateTime());

        return $period->format('%d days %H hours %i minutes');
    }
    /**
     * @var boolean
     */
    private $detailsAccepted;

    /**
     * @var boolean
     */
    private $actsEctrasAccepted;

    /**
     * @var boolean
     */
    private $timingAccepted;

    /**
     * @var boolean
     */
    private $technicalRequirementsAccepted;


    /**
     * Set detailsAccepted
     *
     * @param boolean $detailsAccepted
     *
     * @return EventOffer
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
     * Set actsEctrasAccepted
     *
     * @param boolean $actsEctrasAccepted
     *
     * @return EventOffer
     */
    public function setActsEctrasAccepted($actsEctrasAccepted)
    {
        $this->actsEctrasAccepted = $actsEctrasAccepted;

        return $this;
    }

    /**
     * Get actsEctrasAccepted
     *
     * @return boolean
     */
    public function getActsEctrasAccepted()
    {
        return $this->actsEctrasAccepted;
    }

    /**
     * Set timingAccepted
     *
     * @param boolean $timingAccepted
     *
     * @return EventOffer
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
     * @return EventOffer
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
     * @var boolean
     */
    private $actsExtrasAccepted;


    /**
     * Set actsExtrasAccepted
     *
     * @param boolean $actsExtrasAccepted
     *
     * @return EventOffer
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
}
