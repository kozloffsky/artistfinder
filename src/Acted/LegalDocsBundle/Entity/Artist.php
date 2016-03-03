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
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($name);
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
        $this->slug = $slug;

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
}