<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefPaymentType
 */
class RefPaymentType
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $paymentType;


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
     * Set paymentType
     *
     * @param string $paymentType
     *
     * @return RefPaymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return string
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }
}
