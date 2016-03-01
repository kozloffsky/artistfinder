<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Message
 */
class Message
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $senderUserId;

    /**
     * @var integer
     */
    private $receiverUserId;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set senderUserId
     *
     * @param integer $senderUserId
     *
     * @return Message
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
     * @return Message
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
     * @param string $subject
     *
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set messageText
     *
     * @param string $messageText
     *
     * @return Message
     */
    public function setMessageText($messageText)
    {
        $this->messageText = $messageText;

        return $this;
    }

    /**
     * Get messageText
     *
     * @return string
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
     * @return Message
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
     * @return Message
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
