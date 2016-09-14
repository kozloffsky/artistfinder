<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefCountry
 */
class RefCountry
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $refCurrencies;

    /**
     * Set refCurrency
     *
     * @param \Acted\LegalDocsBundle\Entity\RefCurrency $refCurrency
     *
     * @return RefCountry
     */
    public function addRefCurrency(\Acted\LegalDocsBundle\Entity\RefCurrency $refCurrency = null)
    {
        $this->refCurrencies[] = $refCurrency;

        return $this;
    }

    /**
     * Remove refCurrency
     *
     * @param \Acted\LegalDocsBundle\Entity\RefCurrency $refCurrency
     */
    public function removeRefCurrency(\Acted\LegalDocsBundle\Entity\RefCurrency $refCurrency)
    {
        $this->refCurrencies->removeElement($refCurrency);
    }

    /**
     * Get refCurrencies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRefCurrencies()
    {
        return $this->refCurrencies;
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
     * Set name
     *
     * @param string $name
     *
     * @return RefCountry
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->getName();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $regions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add region
     *
     * @param \Acted\LegalDocsBundle\Entity\RefRegion $region
     *
     * @return RefCountry
     */
    public function addRegion(\Acted\LegalDocsBundle\Entity\RefRegion $region)
    {
        $this->regions[] = $region;

        return $this;
    }

    /**
     * Remove region
     *
     * @param \Acted\LegalDocsBundle\Entity\RefRegion $region
     */
    public function removeRegion(\Acted\LegalDocsBundle\Entity\RefRegion $region)
    {
        $this->regions->removeElement($region);
    }

    /**
     * Get regions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegions()
    {
        return $this->regions;
    }
}
