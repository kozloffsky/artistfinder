<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Performance
 */
class Performance
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    const TYPE_BASE = 0;
    const TYPE_STANDARD = 1;
    const TYPE_CUSTOM = 2;
    const TYPE_TRAVEL_EXPENSES = 3;
    const TYPE_TECHNICAL_EXPENSES = 4;
    const TYPE_MATERIALS = 5;
    const TYPE_OTHER = 6;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $profileId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $techRequirement;

    /**
     * @var boolean
     */
    private $isVisible = true;

    /**
     * @var \DateTime
     */
    private $deletedTime;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $packages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $media;

    /**
     * @var integer
     */
    public $isPricePage = 0;

    /**
     * @var integer
     */
    public $offerMinPrice = 0;

    /**
     * @var integer
     */
    public $minPrice = 0;

    /**
     * @var boolean
     */
    public $priceOnRequest = false;

    /**
     * @var boolean
     */
    private $isQuotation = false;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $performanceRequestQuotations;

    /**
     * @var integer
     */
    private $type = 0;

    /**
     * @var string
     */
    private $comment;

    public function __construct()
    {
        $this->packages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->offers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
        $this->performanceRequestQuotations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add package
     *
     * @param \Acted\LegalDocsBundle\Entity\Package $package
     *
     * @return Performance
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
     * Get existed packages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExistedPackages()
    {
        return $this->packages->filter(
            function ($entry) {
                return is_null($entry->getDeletedTime());
            }
        );
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
     * @return Performance
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
     * @return Performance
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
     * Set status
     *
     * @param string $status
     *
     * @return Performance
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set techRequirement
     *
     * @param string $techRequirement
     *
     * @return Performance
     */
    public function setTechRequirement($techRequirement)
    {
        $this->techRequirement = $techRequirement;

        return $this;
    }

    /**
     * Get techRequirement
     *
     * @return string
     */
    public function getTechRequirement()
    {
        return $this->techRequirement;
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
     * @return Performance
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $offers;


    /**
     * Add offer
     *
     * @param \Acted\LegalDocsBundle\Entity\Offer $offer
     *
     * @return Performance
     */
    public function addOffer(\Acted\LegalDocsBundle\Entity\Offer $offer)
    {
        $this->offers[] = $offer;

        return $this;
    }

    /**
     * Remove offer
     *
     * @param \Acted\LegalDocsBundle\Entity\Offer $offer
     */
    public function removeOffer(\Acted\LegalDocsBundle\Entity\Offer $offer)
    {
        $this->offers->removeElement($offer);
    }

    /**
     * Get offers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOffers()
    {
        return $this->offers;
    }

    public function getOfferMinPrice()
    {
        $prices = $this->offers->map(function ($entry) {
            return $entry->getPrice();
        });

        if(count($prices) < 1){
            return null;
        }

        return min($prices->toArray());
    }

    public function getOfferMaxPrice()
    {
        $prices = $this->offers->map(function ($entry) {
            return $entry->getPrice();
        });

        if(count($prices) < 1){
            return null;
        }

        return max($prices->toArray());
    }

    /**
     * Add medium
     *
     * @param \Acted\LegalDocsBundle\Entity\Media $medium
     *
     * @return Performance
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

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Set isVisible
     *
     * @param string $isVisible
     *
     * @return Performance
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
     * @return Performance
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
     * Get minPrice
     * @return integer
     */
    public function getMinPrice() {
        return $this->minPrice;
    }

    /**
     * Set minPrice
     *
     * @param integer $minPrice
     *
     * @return Performance
     */
    public function setMinPrice($price) {
        $this->minPrice = $price;
    }

    /**
     * Get priceOnRequest
     * @return boolean
     */
    public function getPriceOnRequest() {
        return $this->priceOnRequest;
    }

    /**
     * Set priceOnRequest
     *
     * @param boolean $priceOnRequest
     *
     * @return Performance
     */
    public function setPriceOnRequest($flag) {
        $this->priceOnRequest = $flag;
    }

    /**
     * Add performanceRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\PerformanceRequestQuotation $performanceRequestQuotation
     *
     * @return Performance
     */
    public function addPerformanceRequestQuotation(\Acted\LegalDocsBundle\Entity\PerformanceRequestQuotation $performanceRequestQuotation)
    {
        $this->performanceRequestQuotations[] = $performanceRequestQuotation;

        return $this;
    }

    /**
     * Remove performanceRequestQuotation
     *
     * @param \Acted\LegalDocsBundle\Entity\PerformanceRequestQuotation $performanceRequestQuotation
     */
    public function removePerformanceRequestQuotation(\Acted\LegalDocsBundle\Entity\PerformanceRequestQuotation $performanceRequestQuotation)
    {
        $this->performanceRequestQuotations->removeElement($performanceRequestQuotation);
    }

    /**
     * Get performanceRequestQuotations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPerformanceRequestQuotations()
    {
        return $this->performanceRequestQuotations;
    }

    /**
     * Set isQuotation
     *
     * @param boolean $isQuotation
     *
     * @return Performance
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

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Performance
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Performance
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}
