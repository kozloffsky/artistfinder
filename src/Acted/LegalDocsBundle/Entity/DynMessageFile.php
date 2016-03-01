<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynMessageFile
 */
class DynMessageFile
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
    private $messageFileId;

    /**
     * @var integer
     */
    private $messageId;

    /**
     * @var integer
     */
    private $fileName;

    /**
     * @var integer
     */
    private $fileSize;


    /**
     * Set messageFileId
     *
     * @param integer $messageFileId
     *
     * @return DynMessageFile
     */
    public function setMessageFileId($messageFileId)
    {
        $this->messageFileId = $messageFileId;

        return $this;
    }

    /**
     * Get messageFileId
     *
     * @return integer
     */
    public function getMessageFileId()
    {
        return $this->messageFileId;
    }

    /**
     * Set messageId
     *
     * @param integer $messageId
     *
     * @return DynMessageFile
     */
    public function setMessageId($messageId)
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * Get messageId
     *
     * @return integer
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * Set fileName
     *
     * @param integer $fileName
     *
     * @return DynMessageFile
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return integer
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set fileSize
     *
     * @param \integer $fileSize
     *
     * @return DynMessageFile
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * Get fileSize
     *
     * @return \integer
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }
}
