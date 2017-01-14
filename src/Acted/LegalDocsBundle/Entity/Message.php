<?php

namespace Acted\LegalDocsBundle\Entity;

use Acted\LegalDocsBundle\Entity\ChatRoom;
use Acted\LegalDocsBundle\Entity\User;
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
     * @var User
     */
    private $senderUser;

    /**
     * @var User
     */
    private $receiverUser;

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
     * @var ChatRoom
     */
    private $chatRoom;

    /**
     * @var boolean
     */
    private $archived = false;

    /**
     * @var boolean
     */
    private $hidden = false;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $files;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add file
     *
     * @param \Acted\LegalDocsBundle\Entity\MessageFile $file
     *
     * @return Event
     */
    public function addFile(\Acted\LegalDocsBundle\Entity\MessageFile $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \Acted\LegalDocsBundle\Entity\MessageFile $file
     */
    public function removeFile(\Acted\LegalDocsBundle\Entity\MessageFile $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

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
     * Set senderUser
     *
     * @param User $senderUser
     *
     * @return Message
     */
    public function setSenderUser(User $senderUser)
    {
        $this->senderUser = $senderUser;

        return $this;
    }

    /**
     * Get senderUser
     *
     * @return User
     */
    public function getSenderUser()
    {
        return $this->senderUser;
    }

    /**
     * Set receiverUser
     *
     * @param User $receiverUser
     *
     * @return Message
     */
    public function setReceiverUser(User $receiverUser)
    {
        $this->receiverUser = $receiverUser;

        return $this;
    }

    /**
     * Get receiverUser
     *
     * @return User
     */
    public function getReceiverUser()
    {
        return $this->receiverUser;
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
        //var_dump($this->sendDateTime);exit;
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

    /**
     * @return ChatRoom
     */
    public function getChatRoom()
    {
        return $this->chatRoom;
    }

    /**
     * @param ChatRoom $chatRoom
     * @return  Message
     */
    public function setChatRoom(ChatRoom $chatRoom)
    {
        $this->chatRoom = $chatRoom;
    }

    /**
     * @return boolean
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * @param boolean $archived
     * @return  Message
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
    }

    public function getTimeFromGet()
    {
        $now = new \DateTime();
        $period = $now->diff($this->getSendDateTime());

        return $period->format('%d days %h hours %i minutes');
    }

    /**
     * Get archived
     *
     * @return boolean
     */
    public function getArchived()
    {
        return $this->archived;
    }

    /**
     * @return boolean
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * @param boolean $hidden
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Get hidden
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }
}
