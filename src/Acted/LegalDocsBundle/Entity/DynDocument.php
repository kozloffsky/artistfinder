<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynDocument
 */
class DynDocument
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
    private $documentId;

    /**
     * @var integer
     */
    private $eventId;

    /**
     * @var varchar
     */
    private $documentType;

    /**
     * @var varchar
     */
    private $documentName;

    /**
     * @var mediumint
     */
    private $documentSize;


    /**
     * Set documentId
     *
     * @param integer $documentId
     *
     * @return DynDocument
     */
    public function setDocumentId($documentId)
    {
        $this->documentId = $documentId;

        return $this;
    }

    /**
     * Get documentId
     *
     * @return integer
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * Set eventId
     *
     * @param integer $eventId
     *
     * @return DynDocument
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
     * @param \varchar $documentType
     *
     * @return DynDocument
     */
    public function setDocumentType(\varchar $documentType)
    {
        $this->documentType = $documentType;

        return $this;
    }

    /**
     * Get documentType
     *
     * @return \varchar
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * Set documentName
     *
     * @param \varchar $documentName
     *
     * @return DynDocument
     */
    public function setDocumentName(\varchar $documentName)
    {
        $this->documentName = $documentName;

        return $this;
    }

    /**
     * Get documentName
     *
     * @return \varchar
     */
    public function getDocumentName()
    {
        return $this->documentName;
    }

    /**
     * Set documentSize
     *
     * @param \mediumint $documentSize
     *
     * @return DynDocument
     */
    public function setDocumentSize(\mediumint $documentSize)
    {
        $this->documentSize = $documentSize;

        return $this;
    }

    /**
     * Get documentSize
     *
     * @return \mediumint
     */
    public function getDocumentSize()
    {
        return $this->documentSize;
    }
}
