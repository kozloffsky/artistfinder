<?php

namespace Acted\LegalDocsBundle\Entity;

use Acted\LegalDocsBundle\Entity\TechnicalRequirement;

/**
 * DocumentTechnicalRequirement
 */
class DocumentTechnicalRequirement
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $size;

    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $originalName;

    /**
     * @var TechnicalRequirement
     */
    private $technicalRequirement;

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
     * Set name
     *
     * @param string $name
     *
     * @return DocumentTechnicalRequirement
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
     * Set size
     *
     * @param integer $size
     *
     * @return DocumentTechnicalRequirement
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return DocumentTechnicalRequirement
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return DocumentTechnicalRequirement
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set technical requirement
     *
     * @param TechnicalRequirement $technicalRequirement
     *
     * @return DocumentTechnicalRequirement
     */
    public function setTechnicalRequirement(TechnicalRequirement $technicalRequirement)
    {
        $this->technicalRequirement = $technicalRequirement;

        return $this;
    }

    /**
     * Get technical requirement
     *
     * @return TechnicalRequirement
     */
    public function getTechnicalRequirement()
    {
        return $this->technicalRequirement;
    }

    /**
     * Set original name
     *
     * @param string $originalName
     *
     * @return DocumentTechnicalRequirement
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * Get original name
     *
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }
}

