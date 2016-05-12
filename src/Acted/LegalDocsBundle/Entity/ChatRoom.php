<?php

namespace Acted\LegalDocsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\User;
use Acted\LegalDocsBundle\Entity\Message;

/**
 * ChatRoom
 */
class ChatRoom
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Event
     */
    private $event;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var string
     */
    private $chatRef;

    /**
     * @var User
     */
    private $user;

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
     * Set event
     *
     * @param Event $event
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get event
     *
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set message
     *
     * @param Message $message
     *
     * @return ChatRoom
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getChatRef()
    {
        return $this->chatRef;
    }

    /**
     * @param string $chatRef
     */
    public function setChatRef($chatRef)
    {
        $this->chatRef = $chatRef;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
