<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Package
 */
class Package
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
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $deletedTime;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Performance
     */
    private $performance;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Profile
     */
    private $profile;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Service
     */
    private $service;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $options;

    public function __construct()
    {
        $this->options = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add option
     *
     * @param \Acted\LegalDocsBundle\Entity\Option $option
     * @return Package
     */
    public function addOption(\Acted\LegalDocsBundle\Entity\Option $option) {
        $this->options[] = $option;
        return $this;
    }

    /**
     * Remove option
     * @param \Acted\LegalDocsBundle\Entity\Option $option
     */
    public function removeOption(\Acted\LegalDocsBundle\Entity\Option $option) {
        $this->options->removeElement($option);
    }

    /**
     * Get options
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptions() {
        return $this->options;
    }

    /**
     * Set performance
     *
     * @param \Acted\LegalDocsBundle\Entity\Performance $performance
     *
     * @return Package
     */
    public function setPerformance(\Acted\LegalDocsBundle\Entity\Performance $performance = null)
    {
        $this->performance = $performance;

        return $this;
    }

    /**
     * Get performance
     *
     * @return \Acted\LegalDocsBundle\Entity\Performance
     */
    public function getPerformance()
    {
        return $this->performance;
    }

    /**
     * Set profile
     *
     * @param \Acted\LegalDocsBundle\Entity\Profile $profile
     *
     * @return Package
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
     * Set service
     *
     * @param \Acted\LegalDocsBundle\Entity\Service $service
     *
     * @return Package
     */
    public function setService(\Acted\LegalDocsBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \Acted\LegalDocsBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
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
     * @return Package
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
     * Set deletedTime
     *
     * @param \DateTime $deletedTime
     *
     * @return Package
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
     * Set profileId
     *
     * @param integer $profileId
     *
     * @return Package
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
     * @return Package
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
     * @return Package
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

}
