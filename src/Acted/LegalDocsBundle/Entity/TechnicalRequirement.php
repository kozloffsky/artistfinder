<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * TechnicalRequirement
 */
class TechnicalRequirement
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var Artist
     */
    private $artist;

    /**
     * @var DocumentTechnicalRequirement
     */
    private $documentTechnicalRequirements;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documentTechnicalRequirements = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return TechnicalRequirement
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
     * @return TechnicalRequirement
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
     * Set artist
     *
     * @param Artist $artist
     *
     * @return TechnicalRequirement
     */
    public function setArtist(Artist $artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist
     *
     * @return Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Add document technical requirement
     *
     * @param DocumentTechnicalRequirement $documentTechnicalRequirement
     *
     * @return TechnicalRequirement
     */
    public function addDocumentTechnicalRequirement(DocumentTechnicalRequirement $documentTechnicalRequirement)
    {
        $this->documentTechnicalRequirements[] = $documentTechnicalRequirement;

        return $this;
    }

    /**
     * Remove document technical requirements
     *
     * @param DocumentTechnicalRequirement $documentTechnicalRequirement
     */
    public function removeDocumentTechnicalRequirement(DocumentTechnicalRequirement $documentTechnicalRequirement)
    {
        $this->documentTechnicalRequirements->removeElement($documentTechnicalRequirement);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getDocumentTechnicalRequirements()
    {
        return $this->documentTechnicalRequirements;
    }
}

