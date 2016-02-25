<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynEventOffer
 */
class DynEventOffer
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
     * @var integer
     */
    private $offerId;

    /**
     * @var varchar
     */
    private $status;

    /**
     * @var double
     */
    private $price;

    /**
     * @var int
     */
    private $currencyId;

    /**
     * @var double
     */
    private $depositValue;

    /**
     * @var varchar
     */
    private $depositType;

    /**
     * @var varchar
     */
    private $paymentTerms;

    /**
     * @var varchar
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
     * Set eventId
     *
     * @param integer $eventId
     *
     * @return DynEventOffer
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
     * Set offerId
     *
     * @param integer $offerId
     *
     * @return DynEventOffer
     */
    public function setOfferId($offerId)
    {
        $this->offerId = $offerId;

        return $this;
    }

    /**
     * Get offerId
     *
     * @return integer
     */
    public function getOfferId()
    {
        return $this->offerId;
    }

    /**
     * Set status
     *
     * @param \varchar $status
     *
     * @return DynEventOffer
     */
    public function setStatus(\varchar $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \varchar
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set price
     *
     * @param \double $price
     *
     * @return DynEventOffer
     */
    public function setPrice(\double $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return \double
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set currencyId
     *
     * @param \int $currencyId
     *
     * @return DynEventOffer
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
     * Set depositValue
     *
     * @param \double $depositValue
     *
     * @return DynEventOffer
     */
    public function setDepositValue(\double $depositValue)
    {
        $this->depositValue = $depositValue;

        return $this;
    }

    /**
     * Get depositValue
     *
     * @return \double
     */
    public function getDepositValue()
    {
        return $this->depositValue;
    }

    /**
     * Set depositType
     *
     * @param \varchar $depositType
     *
     * @return DynEventOffer
     */
    public function setDepositType(\varchar $depositType)
    {
        $this->depositType = $depositType;

        return $this;
    }

    /**
     * Get depositType
     *
     * @return \varchar
     */
    public function getDepositType()
    {
        return $this->depositType;
    }

    /**
     * Set paymentTerms
     *
     * @param \varchar $paymentTerms
     *
     * @return DynEventOffer
     */
    public function setPaymentTerms(\varchar $paymentTerms)
    {
        $this->paymentTerms = $paymentTerms;

        return $this;
    }

    /**
     * Get paymentTerms
     *
     * @return \varchar
     */
    public function getPaymentTerms()
    {
        return $this->paymentTerms;
    }

    /**
     * Set comments
     *
     * @param \varchar $comments
     *
     * @return DynEventOffer
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

    /**
     * Set sendDateTime
     *
     * @param \DateTime $sendDateTime
     *
     * @return DynEventOffer
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
     * @return DynEventOffer
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
}
