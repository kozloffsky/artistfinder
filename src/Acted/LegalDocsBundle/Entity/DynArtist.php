<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynArtist
 */
class DynArtist
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
    private $userId;

    /**
     * @var varchar
     */
    private $name;

    /**
     * @var varchar
     */
    private $assistantName;

    /**
     * @var varchar
     */
    private $website;

    /**
     * @var varchar
     */
    private $paymentDetails;

    /**
     * @var double
     */
    private $vatRate;

    /**
     * @var varchar
     */
    private $comments;

    /**
     * @var int
     */
    private $cityId;


    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return DynArtist
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
     * Set name
     *
     * @param \varchar $name
     *
     * @return DynArtist
     */
    public function setName(\varchar $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return \varchar
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set assistantName
     *
     * @param \varchar $assistantName
     *
     * @return DynArtist
     */
    public function setAssistantName(\varchar $assistantName)
    {
        $this->assistantName = $assistantName;

        return $this;
    }

    /**
     * Get assistantName
     *
     * @return \varchar
     */
    public function getAssistantName()
    {
        return $this->assistantName;
    }

    /**
     * Set website
     *
     * @param \varchar $website
     *
     * @return DynArtist
     */
    public function setWebsite(\varchar $website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return \varchar
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set paymentDetails
     *
     * @param \varchar $paymentDetails
     *
     * @return DynArtist
     */
    public function setPaymentDetails(\varchar $paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;

        return $this;
    }

    /**
     * Get paymentDetails
     *
     * @return \varchar
     */
    public function getPaymentDetails()
    {
        return $this->paymentDetails;
    }

    /**
     * Set vatRate
     *
     * @param \double $vatRate
     *
     * @return DynArtist
     */
    public function setVatRate(\double $vatRate)
    {
        $this->vatRate = $vatRate;

        return $this;
    }

    /**
     * Get vatRate
     *
     * @return \double
     */
    public function getVatRate()
    {
        return $this->vatRate;
    }

    /**
     * Set comments
     *
     * @param \varchar $comments
     *
     * @return DynArtist
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
     * Set cityId
     *
     * @param \int $cityId
     *
     * @return DynArtist
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
}
