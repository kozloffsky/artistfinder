<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynPerformance
 */
class DynPerformance
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
    private $performanceId;

    /**
     * @var integer
     */
    private $profileId;

    /**
     * @var varchar
     */
    private $title;

    /**
     * @var varchar
     */
    private $techRequirement;


    /**
     * Set performanceId
     *
     * @param integer $performanceId
     *
     * @return DynPerformance
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
     * Set profileId
     *
     * @param integer $profileId
     *
     * @return DynPerformance
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
     * @param \varchar $title
     *
     * @return DynPerformance
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
     * Set techRequirement
     *
     * @param \varchar $techRequirement
     *
     * @return DynPerformance
     */
    public function setTechRequirement(\varchar $techRequirement)
    {
        $this->techRequirement = $techRequirement;

        return $this;
    }

    /**
     * Get techRequirement
     *
     * @return \varchar
     */
    public function getTechRequirement()
    {
        return $this->techRequirement;
    }
}
