<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * PaymentTermRequestQuotation
 */
class PaymentTermRequestQuotation
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $guaranteedDepositPercent = 0;

    /**
     * @var integer
     */
    private $balancePercent = 0;

    /**
     * @var \Acted\LegalDocsBundle\Entity\RequestQuotation
     */
    private $requestQuotation;


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
     * Set guaranteedDepositPercent
     *
     * @param integer $guaranteedDepositPercent
     *
     * @return PaymentTermRequestQuotation
     */
    public function setGuaranteedDepositPercent($guaranteedDepositPercent)
    {
        $this->guaranteedDepositPercent = $guaranteedDepositPercent;

        return $this;
    }

    /**
     * Get guaranteedDepositPercent
     *
     * @return integer
     */
    public function getGuaranteedDepositPercent()
    {
        return $this->guaranteedDepositPercent;
    }

    /**
     * Set balancePercent
     *
     * @param integer $balancePercent
     *
     * @return PaymentTermRequestQuotation
     */
    public function setBalancePercent($balancePercent)
    {
        $this->balancePercent = $balancePercent;

        return $this;
    }

    /**
     * Get balancePercent
     *
     * @return integer
     */
    public function getBalancePercent()
    {
        return $this->balancePercent;
    }

    /**
     * Set requestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\RequestQuotation $requestQuotation
     *
     * @return PaymentTermRequestQuotation
     */
    public function setRequestQuotation(\Acted\LegalDocsBundle\Entity\RequestQuotation $requestQuotation = null)
    {
        $this->requestQuotation = $requestQuotation;

        return $this;
    }

    /**
     * Get requestQuotation
     *
     * @return \Acted\LegalDocsBundle\Entity\RequestQuotation
     */
    public function getRequestQuotation()
    {
        return $this->requestQuotation;
    }
}
