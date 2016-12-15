<?php

namespace Acted\LegalDocsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Acted\LegalDocsBundle\Entity\Event;
use Acted\LegalDocsBundle\Entity\Offer;
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
     * @var Offer
     */
    private $offer;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var User
     */
    private $artist;

    /**
     * @var User
     */
    private $client;

    /**
     * @var Order
     */
    private $order;

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
     * @return Offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * @param Offer $offer
     */
    public function setOffer(Offer $offer)
    {
        $this->offer = $offer;
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

    public function getLastMessage()
    {
        if ($this->message) {
            return $this->message->last();
        } else {
            return $this->message;
        }

    }

    /**
     * @return User
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param User $artist
     */
    public function setArtist(User $artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return User
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param User $client
     */
    public function setClient(User $client)
    {
        $this->client = $client;
    }

    /**
     * @var string
     */
    private $technicalRequirements;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->message = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set technicalRequirements
     *
     * @param string $technicalRequirements
     *
     * @return ChatRoom
     */
    public function setTechnicalRequirements($technicalRequirements)
    {
        $this->technicalRequirements = $technicalRequirements;

        return $this;
    }

    /**
     * Get technicalRequirements
     *
     * @return string
     */
    public function getTechnicalRequirements()
    {
        return $this->technicalRequirements;
    }

    /**
     * Add message
     *
     * @param \Acted\LegalDocsBundle\Entity\Message $message
     *
     * @return ChatRoom
     */
    public function addMessage(\Acted\LegalDocsBundle\Entity\Message $message)
    {
        $this->message[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \Acted\LegalDocsBundle\Entity\Message $message
     */
    public function removeMessage(\Acted\LegalDocsBundle\Entity\Message $message)
    {
        $this->message->removeElement($message);
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }


}
