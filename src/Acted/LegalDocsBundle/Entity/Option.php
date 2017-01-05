<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Option
 */
class Option
{
    /**
     * @var integer
     */
    private $id;

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

    /**
     * @var \Acted\LegalDocsBundle\Entity\Package
     */
    private $package;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $rates;

    /**
     * @var boolean
     */
    private $priceOnRequest = false;

    /**
     * @var boolean
     */
    private $isSelected = false;

    /**
     * Add rate
     *
     * @param \Acted\LegalDocsBundle\Entity\Rate $rate
     *
     * @return Option
     */
    public function addRate(\Acted\LegalDocsBundle\Entity\Rate $rate)
    {
        $this->rates[] = $rate;

        return $this;
    }

    /**
     * Remove rate
     *
     * @param \Acted\LegalDocsBundle\Entity\Rate $rate
     */
    public function removeRate(\Acted\LegalDocsBundle\Entity\Rate $rate)
    {
        $this->rates->removeElement($rate);
    }

    /**
     * Get rates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRates()
    {
        return $this->rates;
    }

    /**
     * Get existed rates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExistedRates()
    {
        return $this->rates->filter(
            function ($entry) {
                return is_null($entry->getDeletedTime());
            }
        );
    }

    /**
     * Set package
     *
     * @param \Acted\LegalDocsBundle\Entity\Package $package
     *
     * @return Option
     */
    public function setPackage(\Acted\LegalDocsBundle\Entity\Package $package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get package
     *
     * @return \Acted\LegalDocsBundle\Entity\Package
     */
    public function getPackage()
    {
        return $this->package;
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
     * Set qty
     *
     * @param integer $qty
     *
     * @return Option
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
     * @return Option
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
     * @return Option
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

    /**
     * Set priceOnRequest
     *
     * @param boolean $priceOnRequest
     *
     * @return Option
     */
    public function setPriceOnRequest($priceOnRequest)
    {
        $this->priceOnRequest = $priceOnRequest;

        return $this;
    }

    /**
     * Get priceOnRequest
     *
     * @return boolean
     */
    public function getPriceOnRequest()
    {
        return $this->priceOnRequest;
    }

    /**
     * Set isSelected
     *
     * @param boolean $isSelected
     *
     * @return Option
     */
    public function setIsSelected($isSelected)
    {
        $this->isSelected = $isSelected;

        return $this;
    }

    /**
     * Get isSelected
     *
     * @return boolean
     */
    public function getIsSelected()
    {
        return $this->isSelected;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rates = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
