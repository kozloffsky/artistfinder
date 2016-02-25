<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynProfile
 */
class DynProfile
{
    /**
     * @var int
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @var integer
     */
    private $profileId;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var varchar
     */
    private $title;

    /**
     * @var varchar
     */
    private $header;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $isInternational;

    /**
     * @var int
     */
    private $performanceRange;

    /**
     * @var int
     */
    private $paymentTypeId;

    /**
     * @var boolean
     */
    private $active;


    /**
     * Set profileId
     *
     * @param integer $profileId
     *
     * @return DynProfile
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return DynProfile
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
     * @param \varchar $title
     *
     * @return DynProfile
     */
    public function setTitle(\varchar $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return \varchar
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set header
     *
     * @param \varchar $header
     *
     * @return DynProfile
     */
    public function setHeader(\varchar $header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return \varchar
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
     * @return DynProfile
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
     * @return DynProfile
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
     * @param \int $performanceRange
     *
     * @return DynProfile
     */
    public function setPerformanceRange(\int $performanceRange)
    {
        $this->performanceRange = $performanceRange;

        return $this;
    }

    /**
     * Get performanceRange
     *
     * @return \int
     */
    public function getPerformanceRange()
    {
        return $this->performanceRange;
    }

    /**
     * Set paymentTypeId
     *
     * @param \int $paymentTypeId
     *
     * @return DynProfile
     */
    public function setPaymentTypeId(\int $paymentTypeId)
    {
        $this->paymentTypeId = $paymentTypeId;

        return $this;
    }

    /**
     * Get paymentTypeId
     *
     * @return \int
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
     * @return DynProfile
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
}
