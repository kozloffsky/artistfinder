<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Document
 */
class Document
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $eventId;

    /**
     * @var string
     */
    private $documentType;

    /**
     * @var string
     */
    private $documentName;

    /**
     * @var integer
     */
    private $documentSize;


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
     * Set eventId
     *
     * @param integer $eventId
     *
     * @return Document
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Get eventId
     *
     * @return integer
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Set documentType
     *
     * @param string $documentType
     *
     * @return Document
     */
    public function setDocumentType($documentType)
    {
        $this->documentType = $documentType;

        return $this;
    }

    /**
     * Get documentType
     *
     * @return string
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * Set documentName
     *
     * @param string $documentName
     *
     * @return Document
     */
    public function setDocumentName($documentName)
    {
        $this->documentName = $documentName;

        return $this;
    }

    /**
     * Get documentName
     *
     * @return string
     */
    public function getDocumentName()
    {
        return $this->documentName;
    }

    /**
     * Set documentSize
     *
     * @param integer $documentSize
     *
     * @return Document
     */
    public function setDocumentSize($documentSize)
    {
        $this->documentSize = $documentSize;

        return $this;
    }

    /**
     * Get documentSize
     *
     * @return integer
     */
    public function getDocumentSize()
    {
        return $this->documentSize;
    }
}
