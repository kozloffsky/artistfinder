<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Offer
 */
class Offer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $performanceId;

    /**
     * @var string
     */
    private $title;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set performanceId
     *
     * @param integer $performanceId
     *
     * @return Offer
     */
    public function setPerformanceId($performanceId)
    {
        $this->performanceId = $performanceId;

        return $this;
    }

    /**
     * Get performanceId
     *
     * @return integer
     */
    public function getPerformanceId()
    {
        return $this->performanceId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Offer
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
     * Set price
     *
     * @param float $price
     *
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $performance;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->performance = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set performance
     *
     * @param \Acted\LegalDocsBundle\Entity\Performance $performance
     *
     * @return Offer
     */
    public function setPerformance(\Acted\LegalDocsBundle\Entity\Performance $performance = null)
    {
        $this->performance = $performance;

        return $this;
    }

    /**
     * Get performance
     *
     * @return \Acted\LegalDocsBundle\Entity\Performance
     */
    public function getPerformance()
    {
        return $this->performance;
    }
}
