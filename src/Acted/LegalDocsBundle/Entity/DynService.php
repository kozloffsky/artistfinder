<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynService
 */
class DynService
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
    private $serviceId;

    /**
     * @var integer
     */
    private $performanceId;

    /**
     * @var varchar
     */
    private $title;

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
     * Set serviceId
     *
     * @param integer $serviceId
     *
     * @return DynService
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;

        return $this;
    }

    /**
     * Get serviceId
     *
     * @return integer
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * Set performanceId
     *
     * @param integer $performanceId
     *
     * @return DynService
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
     * @param \varchar $title
     *
     * @return DynService
     */
    public function setTitle(\varchar $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return \varchar
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set price
     *
     * @param \double $price
     *
     * @return DynService
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
     * @return DynService
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
     * @return DynService
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
     * @return DynService
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
     * @return DynService
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
     * @return DynService
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
}
