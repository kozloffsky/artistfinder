<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * PriceOption
 */
class PriceOptionRate
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $price;

    private $deletedTime;

    private $priceOption;

    /**
     * Set priceOption
     *
     * @param \Acted\LegalDocsBundle\Entity\PriceOptionRate $priceOption
     *
     * @return PriceOptionRate
     */
    public function setPriceOption(\Acted\LegalDocsBundle\Entity\PriceOption $priceOption = null)
    {
        $this->priceOption = $priceOption;

        return $this;
    }

    /**
     * Get priceOption
     *
     * @return \Acted\LegalDocsBundle\Entity\PriceOption
     */
    public function getPriceOption()
    {
        return $this->priceOption;
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
     * Set price
     *
     * @param integer $price
     *
     * @return PriceOptionRate
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set deletedTime
     *
     * @param \DateTime $deletedTime
     *
     * @return PriceOptionRate
     */
    public function setDeletedTime($deletedTime)
    {
        $this->deletedTime = $deletedTime;

        return $this;
    }

    /**
     * Get deletedTime
     *
     * @return \DateTime
     */
    public function getDeletedTime()
    {
        return $this->deletedTime;
    }
}
