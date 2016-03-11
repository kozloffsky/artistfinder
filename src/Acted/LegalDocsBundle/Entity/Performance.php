<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Performance
 */
class Performance
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
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $techRequirement;


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
        return min($prices->toArray());
    }

    public function getOfferMaxPrice()
    {
        $prices = $this->offers->map(function ($entry) {
            return $entry->getPrice();
        });
        return max($prices->toArray());
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
        $this->offers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
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
}
