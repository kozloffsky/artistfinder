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
    private $profileId;

    /**
     * @var integer
     */
    private $serviceId;

    /**
     * @var integer
     */
    private $performanceId;

    /**
     * @var \DateTime
     */
    private $deletedTime;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $services;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pricePackages;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->services = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add pricePackage
     *
     * @param \Acted\LegalDocsBundle\Entity\PricePackage $pricePackage
     *
     * @return Price
     */
    public function addPricePackage(\Acted\LegalDocsBundle\Entity\PricePackage $pricePackage)
    {
        $this->pricePackages[] = $pricePackage;

        return $this;
    }

    /**
     * Remove pricePackage
     *
     * @param \Acted\LegalDocsBundle\Entity\PricePackage $pricePackage
     */
    public function removePricePackage(\Acted\LegalDocsBundle\Entity\PricePackage $pricePackage)
    {
        $this->pricePackages->removeElement($pricePackage);
    }

    /**
     * Get pricePackages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPricePackages()
    {
        return $this->pricePackages;
    }

    /**
     * Add service
     *
     * @param \Acted\LegalDocsBundle\Entity\Service $service
     *
     * @return Price
     */
    public function addService(\Acted\LegalDocsBundle\Entity\Service $service)
    {
        $this->services[] = $service;
        return $this;
    }

    /**
     * Remove service
     *
     * @param \Acted\LegalDocsBundle\Entity\Service $service
     */
    public function removeService(\Acted\LegalDocsBundle\Entity\Service $service)
    {
        $this->services->removeElement($service);
    }

    /**
     * Get services
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $performances;

    /**
     * Add performance
     *
     * @param \Acted\LegalDocsBundle\Entity\Performance $performance
     *
     * @return Price
     */
    public function addPerformance(\Acted\LegalDocsBundle\Entity\Performance $performance)
    {
        $this->performances[] = $performance;

        return $this;
    }

    /**
     * Remove performance
     *
     * @param \Acted\LegalDocsBundle\Entity\Performance $performance
     */
    public function removePerformance(\Acted\LegalDocsBundle\Entity\Performance $performance)
    {
        $this->performances->removeElement($performance);
    }

    /**
     * Get performances
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerformances()
    {
        return $this->performances;
    }

    /**
     * @var \Acted\LegalDocsBundle\Entity\Profile
     */
    private $profile;


    /**
     * Set profile
     *
     * @param \Acted\LegalDocsBundle\Entity\Profile $profile
     *
     * @return Price
     */
    public function setProfile(\Acted\LegalDocsBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \Acted\LegalDocsBundle\Entity\Profile
     */
    public function getProfile()
    {
        return $this->profile;
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
     * Set profileId
     *
     * @param integer $profileId
     *
     * @return Price
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;

        return $this;
    }

    /**
     * Get profileId
     *
     * @return integer
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * Set serviceId
     *
     * @param integer $serviceId
     *
     * @return Price
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
     * @return Price
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
     * Set deletedTime
     *
     * @param \DateTime $deletedTime
     *
     * @return Price
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
