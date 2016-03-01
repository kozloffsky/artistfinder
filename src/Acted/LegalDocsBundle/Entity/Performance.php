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
}
