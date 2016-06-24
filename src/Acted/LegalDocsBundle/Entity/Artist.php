<?php

namespace Acted\LegalDocsBundle\Entity;
use Cocur\Slugify\Slugify;

/**
 * Artist
 */
class Artist
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
    private $name;

    /**
     * @var string
     */
    private $assistantName;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $paymentDetails;

    /**
     * @var float
     */
    private $vatRate;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var integer
     */
    private $cityId;


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
     * @return Artist
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
     * Set name
     *
     * @param string $name
     *
     * @return Artist
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

    /**
     * Set assistantName
     *
     * @param string $assistantName
     *
     * @return Artist
     */
    public function setAssistantName($assistantName)
    {
        $this->assistantName = $assistantName;

        return $this;
    }

    /**
     * Get assistantName
     *
     * @return string
     */
    public function getAssistantName()
    {
        return $this->assistantName;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Artist
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set paymentDetails
     *
     * @param string $paymentDetails
     *
     * @return Artist
     */
    public function setPaymentDetails($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;

        return $this;
    }

    /**
     * Get paymentDetails
     *
     * @return string
     */
    public function getPaymentDetails()
    {
        return $this->paymentDetails;
    }

    /**
     * Set vatRate
     *
     * @param float $vatRate
     *
     * @return Artist
     */
    public function setVatRate($vatRate)
    {
        $this->vatRate = $vatRate;

        return $this;
    }

    /**
     * Get vatRate
     *
     * @return float
     */
    public function getVatRate()
    {
        return $this->vatRate;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Artist
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set cityId
     *
     * @param integer $cityId
     *
     * @return Artist
     */
    public function setCityId($cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return integer
     */
    public function getCityId()
    {
        return $this->cityId;
    }
    /**
     * @var string
     */
    private $slug;


    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Artist
     */
    public function setSlug($slug)
    {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($slug);
        return $this;
    }
    /**
     * @var \Acted\LegalDocsBundle\Entity\RefCity
     */
    private $city;


    /**
     * Set city
     *
     * @param \Acted\LegalDocsBundle\Entity\RefCity $city
     *
     * @return Artist
     */
    public function setCity(\Acted\LegalDocsBundle\Entity\RefCity $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Acted\LegalDocsBundle\Entity\RefCity
     */
    public function getCity()
    {
        return $this->city;
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
     * @return Artist
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
    private $ratings;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ratings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add rating
     *
     * @param \Acted\LegalDocsBundle\Entity\ArtistRating $rating
     *
     * @return Artist
     */
    public function addRating(\Acted\LegalDocsBundle\Entity\ArtistRating $rating)
    {
        $this->ratings[] = $rating;

        return $this;
    }

    /**
     * Remove rating
     *
     * @param \Acted\LegalDocsBundle\Entity\ArtistRating $rating
     */
    public function removeRating(\Acted\LegalDocsBundle\Entity\ArtistRating $rating)
    {
        $this->ratings->removeElement($rating);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    public function getRating()
    {
        $ratings = $this->ratings->map(function($entry){
            /** @var ArtistRating $entry */
            return $entry->getRating();
        });

        $count = $ratings->count();

        if($count == 0) {
            return 0;
        }

        return number_format(array_sum($ratings->toArray())/$ratings->count(), 1);
    }

    public function getVotesCount()
    {
        return count($this->ratings);
    }

    public function __toString()
    {
        return $this->getName();
    }
    /**
     * @var \Acted\LegalDocsBundle\Entity\RefCountry
     */
    private $country;


    /**
     * Set country
     *
     * @param \Acted\LegalDocsBundle\Entity\RefCountry $country
     *
     * @return Artist
     */
    public function setCountry(\Acted\LegalDocsBundle\Entity\RefCountry $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Acted\LegalDocsBundle\Entity\RefCountry
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * @var int
     */
    private $recommend = 0;

    /**
     * @var int
     */
    private $spotlight = 0;

    /**
     * Set recommend
     *
     * @param int $recommend
     *
     * @return Artist
     */
    public function setRecommend($recommend)
    {
        $this->recommend = $recommend;

        return $this;
    }

    /**
     * Get recommend
     *
     * @return int
     */
    public function getRecommend()
    {
        return $this->recommend;
    }

    /**
     * Set spotlight
     *
     * @param int $spotlight
     *
     * @return Artist
     */
    public function setSpotlight($spotlight)
    {
        $this->spotlight = $spotlight;

        return $this;
    }

    /**
     * Get spotlight
     *
     * @return int
     */
    public function getSpotlight()
    {
        return $this->spotlight;
    }

    public function getCityName()
    {
        return ($this->city) ? $this->city->getName() : null;
    }

    public function getCountryName()
    {
        return ($this->city && $this->city->getRegion()->getCountry()) ? $this->city->getRegion()->getCountry()->getName() : null;
    }

    public function getCategoriesNames()
    {
        if ($this->getUser()->getProfile()) {
            return $this->getUser()->getProfile()->getCategories()->map(function($entry){
                /** @var Category $entry */
                return $entry->getTitle();
            });
        }
        return [];
    }

    public function getLastPerformanceMedia()
    {
        if ($this->getUser()->getProfile()) {
            /** @var Performance $performance */
            $performance = $this->getUser()->getProfile()->getPerformances()->first();
            if ($performance) {
                return $performance->getMedia()->first();
            }
        }
        return null;
    }

    public function getAllPerformance()
    {
        if ($this->getUser()->getProfile()) {
            /** @var Performance $performance */
            $performances = $this->getUser()->getProfile()->getPerformances();
            $result = [];
            foreach ($performances as $performance) {
                $result[] = ['id' => $performance->getId(), 'name' => $performance->getTitle()];
            }
            return $result;
        }
        return null;
    }


}
