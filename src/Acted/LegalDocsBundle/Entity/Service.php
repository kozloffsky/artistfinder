<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Service
 */
class Service
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    public $profileId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var boolean
     */
    private $isVisible = true;

    /**
     * @var \DateTime
     */
    private $deletedTime;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Price
     */
    private $price;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Profile
     */
    private $profile;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $packages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $serviceRequestQuotations;

    public function __construct() {
        $this->packages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->serviceRequestQuotations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add package
     *
     * @param \Acted\LegalDocsBundle\Entity\Package $package
     *
     * @return Service
     */
    public function addPackage(\Acted\LegalDocsBundle\Entity\Package $package)
    {
        $this->packages[] = $package;
        return $this;
    }

    /**
     * Remove package
     *
     * @param \Acted\LegalDocsBundle\Entity\Package $package
     */
    public function removePackage(\Acted\LegalDocsBundle\Entity\Package $package)
    {
        $this->packages->removeElement($package);
    }


    /**
     * Get packages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * Set profile
     *
     * @param \Acted\LegalDocsBundle\Entity\Profile $profile
     *
     * @return Service
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
     * Set price
     *
     * @param \Acted\LegalDocsBundle\Entity\Price $price
     *
     * @return Service
     */
    public function setPrice(\Acted\LegalDocsBundle\Entity\Price $price = null)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return \Acted\LegalDocsBundle\Entity\Price
     */
    public function getPrice()
    {
        return $this->price;
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
     * @return Service
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
     * Set title
     *
     * @param string $title
     *
     * @return Service
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set isVisible
     *
     * @param string $isVisible
     *
     * @return Service
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return string
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    /**
     * Set deletedTime
     *
     * @param \DateTime $deletedTime
     *
     * @return Service
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
     * Add serviceRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\ServiceRequestQuotation $serviceRequestQuotation
     *
     * @return Service
     */
    public function addServiceRequestQuotation(\Acted\LegalDocsBundle\Entity\ServiceRequestQuotation $serviceRequestQuotation)
    {
        $this->serviceRequestQuotations[] = $serviceRequestQuotation;

        return $this;
    }

    /**
     * Remove serviceRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\ServiceRequestQuotation $serviceRequestQuotation
     */
    public function removeServiceRequestQuotation(\Acted\LegalDocsBundle\Entity\ServiceRequestQuotation $serviceRequestQuotation)
    {
        $this->serviceRequestQuotations->removeElement($serviceRequestQuotation);
    }

    /**
     * Get serviceRequestQuotations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getServiceRequestQuotations()
    {
        return $this->serviceRequestQuotations;
    }
    /**
     * @var boolean
     */
    private $isQuotation = false;


    /**
     * Set isQuotation
     *
     * @param boolean $isQuotation
     *
     * @return Service
     */
    public function setIsQuotation($isQuotation)
    {
        $this->isQuotation = $isQuotation;

        return $this;
    }

    /**
     * Get isQuotation
     *
     * @return boolean
     */
    public function getIsQuotation()
    {
        return $this->isQuotation;
    }
}
