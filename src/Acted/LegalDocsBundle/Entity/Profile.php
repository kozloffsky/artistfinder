<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Profile
 */
class Profile
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $header;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $isInternational = false;

    /**
     * @var integer
     */
    private $performanceRange;

    /**
     * @var integer
     */
    private $paymentTypeId;

    /**
     * @var boolean
     */
    private $active = false;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $packages;

    /**
     * Add package
     *
     * @param \Acted\LegalDocsBundle\Entity\Package $package
     *
     * @return Profile
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Profile
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Profile
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
     * Set header
     *
     * @param string $header
     *
     * @return Profile
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Profile
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isInternational
     *
     * @param boolean $isInternational
     *
     * @return Profile
     */
    public function setIsInternational($isInternational)
    {
        $this->isInternational = $isInternational;

        return $this;
    }

    /**
     * Get isInternational
     *
     * @return boolean
     */
    public function getIsInternational()
    {
        return $this->isInternational;
    }

    /**
     * Set performanceRange
     *
     * @param integer $performanceRange
     *
     * @return Profile
     */
    public function setPerformanceRange($performanceRange)
    {
        $this->performanceRange = $performanceRange;

        return $this;
    }

    /**
     * Get performanceRange
     *
     * @return integer
     */
    public function getPerformanceRange()
    {
        return $this->performanceRange;
    }

    /**
     * Set paymentTypeId
     *
     * @param integer $paymentTypeId
     *
     * @return Profile
     */
    public function setPaymentTypeId($paymentTypeId)
    {
        $this->paymentTypeId = $paymentTypeId;

        return $this;
    }

    /**
     * Get paymentTypeId
     *
     * @return integer
     */
    public function getPaymentTypeId()
    {
        return $this->paymentTypeId;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Profile
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }
    /**
     * @var string
     */
    private $oneToOne;


    /**
     * Set oneToOne
     *
     * @param string $oneToOne
     *
     * @return Profile
     */
    public function setOneToOne($oneToOne)
    {
        $this->oneToOne = $oneToOne;

        return $this;
    }

    /**
     * Get oneToOne
     *
     * @return string
     */
    public function getOneToOne()
    {
        return $this->oneToOne;
    }
    /**
     * @var \Acted\LegalDocsBundle\Entity\User
     */
    private $user;


    /**
     * Set user
     *
     * @param \Acted\LegalDocsBundle\Entity\User $user
     *
     * @return Profile
     */
    public function setUser(\Acted\LegalDocsBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Acted\LegalDocsBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $prices;

    /**
     * Add price
     *
     * @param \Acted\LegalDocsBundle\Entity\Price $price
     *
     * @return Profile
     */
    public function addPrice(\Acted\LegalDocsBundle\Entity\Price $price)
    {
        $this->prices[] = $price;

        return $this;
    }

    /**
     * Remove price
     *
     * @param \Acted\LegalDocsBundle\Entity\Media $price
     */
    public function removePrice(\Acted\LegalDocsBundle\Entity\Price $price)
    {
        $this->prices->removeElement($price);
    }

    /**
     * Get prices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $media;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
        $this->packages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add medium
     *
     * @param \Acted\LegalDocsBundle\Entity\Media $medium
     *
     * @return Profile
     */
    public function addMedia(\Acted\LegalDocsBundle\Entity\Media $medium)
    {
        $this->media[] = $medium;

        return $this;
    }

    /**
     * Remove medium
     *
     * @param \Acted\LegalDocsBundle\Entity\Media $medium
     */
    public function removeMedia(\Acted\LegalDocsBundle\Entity\Media $medium)
    {
        $this->media->removeElement($medium);
    }

    /**
     * Get media
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedia()
    {
        return $this->media;
    }

    public function getPhotoList()
    {
        return $this->getFilteredMedia('photo');
    }

    public function getVideoList()
    {
        return $this->getFilteredMedia('video');
    }

    public function getAudioList()
    {
        return $this->getFilteredMedia('audio');
    }

    protected function getFilteredMedia($type)
    {
        return $this->media->filter(function($entry) use($type) {
            /** @var Media $entry */
            return ($entry->getMediaType() == $type);
        });
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
     * @return Profile
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
        $performances = [];

        foreach ($this->performances as $performance) {
            if (!$performance->getIsQuotation())
                $performances[] = $performance;
        }

        return $performances;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $services;

    /**
     * Add service
     *
     * @param \Acted\LegalDocsBundle\Entity\Service $service
     *
     * @return Profile
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
        $services = [];

        foreach ($this->services as $service) {
            if (!$service->getIsQuotation())
                $services[] = $service;
        }

        return $services;
    }


    public function getMinPrice()
    {
        $prices = $this->getPerformances()->map(function($entry){
            /** @var Performance $entry */
            return $entry->getOfferMinPrice();
        });

        if(count($prices) < 1){
            return null;
        }

        return min($prices->toArray());
    }

    public function getMaxPrice()
    {
        $prices = $this->getPerformances()->map(function($entry){
            /** @var Performance $entry */
            return $entry->getOfferMaxPrice();
        });

        if(count($prices) < 1){
            return null;
        }

        return max($prices->toArray());
    }

    public function __toString()
    {
        return $this->getTitle();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $categories;


    /**
     * Add category
     *
     * @param \Acted\LegalDocsBundle\Entity\Category $category
     *
     * @return Profile
     */
    public function addCategory(\Acted\LegalDocsBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Acted\LegalDocsBundle\Entity\Category $category
     */
    public function removeCategory(\Acted\LegalDocsBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }
}
