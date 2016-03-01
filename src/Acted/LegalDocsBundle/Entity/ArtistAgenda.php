<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * ArtistAgenda
 */
class ArtistAgenda
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
    private $description;

    /**
     * @var \DateTime
     */
    private $startingDatetime;

    /**
     * @var \DateTime
     */
    private $endingDatetime;


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
     * @return ArtistAgenda
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
     * @return ArtistAgenda
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
     * Set description
     *
     * @param string $description
     *
     * @return ArtistAgenda
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
     * Set startingDatetime
     *
     * @param \DateTime $startingDatetime
     *
     * @return ArtistAgenda
     */
    public function setStartingDatetime($startingDatetime)
    {
        $this->startingDatetime = $startingDatetime;

        return $this;
    }

    /**
     * Get startingDatetime
     *
     * @return \DateTime
     */
    public function getStartingDatetime()
    {
        return $this->startingDatetime;
    }

    /**
     * Set endingDatetime
     *
     * @param \DateTime $endingDatetime
     *
     * @return ArtistAgenda
     */
    public function setEndingDatetime($endingDatetime)
    {
        $this->endingDatetime = $endingDatetime;

        return $this;
    }

    /**
     * Get endingDatetime
     *
     * @return \DateTime
     */
    public function getEndingDatetime()
    {
        return $this->endingDatetime;
    }
}
