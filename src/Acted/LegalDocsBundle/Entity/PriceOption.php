<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * PriceOption
 */
class PriceOption
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $packageId;

    /**
     * @var integer
     */
    private $qty;

    /**
     * @var integer
     */
    private $duration;

    /**
     * @var \DateTime
     */
    private $deletedTime;

    private $pricePackage;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $priceOptionRates;

    /**
     * Add priceOptionRate
     *
     * @param \Acted\LegalDocsBundle\Entity\PriceOptionRate $priceOptionRate
     *
     * @return PriceOption
     */
    public function addPriceOptionRate(\Acted\LegalDocsBundle\Entity\PriceOptionRate $priceOptionRate)
    {
        $this->priceOptionRates[] = $priceOptionRate;

        return $this;
    }

    /**
     * Remove priceOptionRate
     *
     * @param \Acted\LegalDocsBundle\Entity\PriceOptionRate $priceOptionRate
     */
    public function removePriceOptionRate(\Acted\LegalDocsBundle\Entity\PriceOptionRate $priceOptionRate)
    {
        $this->priceOptionRates->removeElement($priceOptionRate);
    }

    /**
     * Get priceOptionRates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPriceOptionRates()
    {
        return $this->priceOptionRates;
    }


    /**
     * Set pricePackage
     *
     * @param \Acted\LegalDocsBundle\Entity\PricePackage $pricePackage
     *
     * @return PriceOption
     */
    public function setPricePackage(\Acted\LegalDocsBundle\Entity\PricePackage $pricePackage = null)
    {
        $this->pricePackage = $pricePackage;

        return $this;
    }

    /**
     * Get pricePackage
     *
     * @return \Acted\LegalDocsBundle\Entity\PricePackage
     */
    public function getPricePackage()
    {
        return $this->pricePackage;
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
     * Set packageId
     *
     * @param integer $packageId
     *
     * @return PriceOption
     */
    public function setPackageId($packageId)
    {
        $this->packageId = $packageId;

        return $this;
    }

    /**
     * Get packageId
     *
     * @return integer
     */
    public function getPackageId()
    {
        return $this->packageId;
    }

    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return PriceOption
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return integer
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return PriceOption
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set deletedTime
     *
     * @param \DateTime $deletedTime
     *
     * @return PriceOption
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
