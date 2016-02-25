<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynArtistAgenda
 */
class DynArtistAgenda
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
    private $agendaId;

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
     * Set agendaId
     *
     * @param integer $agendaId
     *
     * @return DynArtistAgenda
     */
    public function setAgendaId($agendaId)
    {
        $this->agendaId = $agendaId;

        return $this;
    }

    /**
     * Get agendaId
     *
     * @return integer
     */
    public function getAgendaId()
    {
        return $this->agendaId;
    }

    /**
     * Set profileId
     *
     * @param integer $profileId
     *
     * @return DynArtistAgenda
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
     * @return DynArtistAgenda
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
     * Set description
     *
     * @param \varchar $description
     *
     * @return DynArtistAgenda
     */
    public function setDescription(\varchar $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return \varchar
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
     * @return DynArtistAgenda
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
     * @return DynArtistAgenda
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
