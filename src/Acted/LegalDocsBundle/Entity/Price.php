<?php

namespace Acted\LegalDocsBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Price
 */
class Price
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $amount;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Rate
     */
    private $rate;

    /**
     * Get rate
     *
     * @return \Acted\LegalDocsBundle\Entity\Rate
     */
    public function getRate()
    {
        return $this->rate;
    }

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
     * Set amount
     *
     * @return Price
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

}
