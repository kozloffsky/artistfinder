<?php

namespace Acted\LegalDocsBundle\Entity;

use Acted\LegalDocsBundle\Entity\Message;
/**
 * MessageFile
 */
class MessageFile
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var integer
     */
    private $fileName;

    /**
     * @var integer
     */
    private $fileSize;


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
     * Set Message
     *
     * @param Message $message
     *
     * @return MessageFile
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get messageId
     *
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set fileName
     *
     * @param integer $fileName
     *
     * @return MessageFile
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
     * @param integer $fileSize
     *
     * @return MessageFile
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * Get fileSize
     *
     * @return integer
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }
}
