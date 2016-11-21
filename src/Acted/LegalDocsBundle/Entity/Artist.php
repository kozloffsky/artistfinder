<?php

namespace Acted\LegalDocsBundle\Entity;
use Cocur\Slugify\Slugify;
use Acted\LegalDocsBundle\Entity\Recommend;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $recommends;

    /**
     * @var boolean
     */
    private $workAbroad = false;

    /**
     * @var string
     */
    private $searchImage;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $technicalRequirements;

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


    public function getCityProfileId()
    {
        return ($this->city) ? $this->city->getId() : null;
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
        $this->recommends = new \Doctrine\Common\Collections\ArrayCollection();
        $this->technicalRequirements = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getCurrency()
    {
        return ($this->country && $this->country->getRefCurrency()) ? $this->country->getRefCurrency() : null;
    }

    /**
     * @var int
     */
    private $spotlight;

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
     * Add recommend
     *
     * @param Recommend $recommend
     *
     * @return Artist
     */
    public function addRecommend(Recommend $recommend)
    {
        $this->recommends[] = $recommend;

        return $this;
    }

    /**
     * Remove recommend
     *
     * @param Recommend $recommend
     */
    public function removeRecommend(Recommend $recommend)
    {
        $this->recommends->removeElement($recommend);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getRecommends()
    {
        return $this->recommends;
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

    public function getCountryId()
    {
        return ($this->city && $this->city->getRegion()->getCountry()) ? $this->city->getRegion()->getCountry()->getId() : null;
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
            $performances = $this->getUser()->getProfile()->getPerformances();
            $performance = '';

            $len = count($performances);

            $perfCopy = $performances->getValues();

            for($i = 0; $i < $len; $i++) {
                if ($perfCopy[$i]->getStatus() === Performance::STATUS_PUBLISHED &&
                    $perfCopy[$i]->getIsVisible() == true &&
                    empty($perfCopy[$i]->getDeletedTime())
                ) {
                    $performance = $perfCopy[$i];
                    break;
                }
            }

            if ($performance) {
                return $performance->getMedia()->first();
            }
        }
        return '';
    }

    public function getAllPerformance()
    {
        if ($this->getUser()->getProfile()) {
            /** @var Performance $performance */
            $performances = $this->getUser()->getProfile()->getPerformances();
            $result = [];
            foreach ($performances as $performance) {
                if (!$performance->getIsQuotation() && $performance->getIsVisible() && is_null($performance->getDeletedTime()))
                    $result[] = [
                        'id' => $performance->getId(),
                        'status'=>$performance->getStatus(),
                        'name' => $performance->getTitle()
                    ];
            }
            return $result;
        }
        return null;
    }

    /**
     * Set workAbroad
     *
     * @param boolean $workAbroad
     *
     * @return Artist
     */
    public function setWorkAbroad($workAbroad)
    {
        $this->workAbroad = $workAbroad;

        return $this;
    }

    /**
     * Get workAbroad
     *
     * @return boolean
     */
    public function getWorkAbroad()
    {
        return $this->workAbroad;
    }

    /**
     * Set search image
     *
     * @param string $searchImage
     *
     * @return Artist
     */
    public function setSearchImage($searchImage)
    {
        $this->searchImage =  '/' . $searchImage;

        return $this;
    }

    /**
     * Get search image
     *
     * @return string
     */
    public function getSearchImage()
    {
        return $this->rel2abs($this->searchImage);
    }

    protected  function rel2abs($link)
    {
        if (strpos($link, 'http') === 0) {
            return $link;
        }

        return '/'.ltrim($link, '/');
    }

    /**
     * Add technical requirement
     *
     * @param TechnicalRequirement $technicalRequirement
     *
     * @return Artist
     */
    public function addTechnicalRequirement(TechnicalRequirement $technicalRequirement)
    {
        $this->technicalRequirements[] = $technicalRequirement;

        return $this;
    }

    /**
     * Remove technical requirements
     *
     * @param TechnicalRequirement $technicalRequirement
     */
    public function removeTechnicalRequirement(TechnicalRequirement $technicalRequirement)
    {
        $this->technicalRequirements->removeElement($technicalRequirement);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getTechnicalRequirements()
    {
        return $this->technicalRequirements;
    }

    /**
     * Get city lat
     *
     * @return double
     */
    public function getCityLat()
    {
        return $this->city->getLatitude();
    }

    /**
     * Get city lng
     *
     * @return double
     */
    public function getCityLng()
    {
        return $this->city->getLongitude();
    }

    /**
     * Get region lat
     *
     * @return double
     */
    public function getRegLat()
    {
        return $this->city->getRegion()->getLatitude();
    }
    /**
     * Get region lng
     *
     * @return double
     */
    public function getRegLng()
    {
        return $this->city->getRegion()->getLongitude();
    }
    /**
     * Get region name
     *
     * @return string
     */
    public function getRegName()
    {
        return $this->city->getRegion()->getName();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $feedbacks;


    /**
     * Add feedback
     *
     * @param \Acted\LegalDocsBundle\Entity\Feedbacks $feedback
     *
     * @return Artist
     */
    public function addFeedback(\Acted\LegalDocsBundle\Entity\Feedbacks $feedback)
    {
        $this->feedbacks[] = $feedback;

        return $this;
    }

    /**
     * Remove feedback
     *
     * @param \Acted\LegalDocsBundle\Entity\Feedbacks $feedback
     */
    public function removeFeedback(\Acted\LegalDocsBundle\Entity\Feedbacks $feedback)
    {
        $this->feedbacks->removeElement($feedback);
    }

    /**
     * Get feedbacks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFeedbacks()
    {
        return $this->feedbacks;
    }
}
