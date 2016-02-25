<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefPaymentType
 */
class RefPaymentType
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
     * @var int
     */
    private $paymentId;

    /**
     * @var varchar
     */
    private $paymentType;


    /**
     * Set paymentId
     *
     * @param \int $paymentId
     *
     * @return RefPaymentType
     */
    public function setPaymentId(\int $paymentId)
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    /**
     * Get paymentId
     *
     * @return \int
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * Set paymentType
     *
     * @param \varchar $paymentType
     *
     * @return RefPaymentType
     */
    public function setPaymentType(\varchar $paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return \varchar
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }
}
