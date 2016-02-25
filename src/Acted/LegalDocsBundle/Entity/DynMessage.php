<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynMessage
 */
class DynMessage
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
    private $messageId;

    /**
     * @var integer
     */
    private $senderUserId;

    /**
     * @var integer
     */
    private $receiverUserId;

    /**
     * @var varchar
     */
    private $subject;

    /**
     * @var varchar
     */
    private $messageText;

    /**
     * @var \DateTime
     */
    private $sendDateTime;

    /**
     * @var \DateTime
     */
    private $readDateTime;


    /**
     * Set messageId
     *
     * @param integer $messageId
     *
     * @return DynMessage
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
     * Set senderUserId
     *
     * @param integer $senderUserId
     *
     * @return DynMessage
     */
    public function setSenderUserId($senderUserId)
    {
        $this->senderUserId = $senderUserId;

        return $this;
    }

    /**
     * Get senderUserId
     *
     * @return integer
     */
    public function getSenderUserId()
    {
        return $this->senderUserId;
    }

    /**
     * Set receiverUserId
     *
     * @param integer $receiverUserId
     *
     * @return DynMessage
     */
    public function setReceiverUserId($receiverUserId)
    {
        $this->receiverUserId = $receiverUserId;

        return $this;
    }

    /**
     * Get receiverUserId
     *
     * @return integer
     */
    public function getReceiverUserId()
    {
        return $this->receiverUserId;
    }

    /**
     * Set subject
     *
     * @param \varchar $subject
     *
     * @return DynMessage
     */
    public function setSubject(\varchar $subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \varchar
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set messageText
     *
     * @param \varchar $messageText
     *
     * @return DynMessage
     */
    public function setMessageText(\varchar $messageText)
    {
        $this->messageText = $messageText;

        return $this;
    }

    /**
     * Get messageText
     *
     * @return \varchar
     */
    public function getMessageText()
    {
        return $this->messageText;
    }

    /**
     * Set sendDateTime
     *
     * @param \DateTime $sendDateTime
     *
     * @return DynMessage
     */
    public function setSendDateTime($sendDateTime)
    {
        $this->sendDateTime = $sendDateTime;

        return $this;
    }

    /**
     * Get sendDateTime
     *
     * @return \DateTime
     */
    public function getSendDateTime()
    {
        return $this->sendDateTime;
    }

    /**
     * Set readDateTime
     *
     * @param \DateTime $readDateTime
     *
     * @return DynMessage
     */
    public function setReadDateTime($readDateTime)
    {
        $this->readDateTime = $readDateTime;

        return $this;
    }

    /**
     * Get readDateTime
     *
     * @return \DateTime
     */
    public function getReadDateTime()
    {
        return $this->readDateTime;
    }
}
