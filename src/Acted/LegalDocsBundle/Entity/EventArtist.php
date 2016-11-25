<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * EventArtist
 */
class EventArtist
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Artist
     */
    private $artist;


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
     * Set event
     *
     * @param \Acted\LegalDocsBundle\Entity\Event $event
     *
     * @return EventArtist
     */
    public function setEvent(\Acted\LegalDocsBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Acted\LegalDocsBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set artist
     *
     * @param \Acted\LegalDocsBundle\Entity\Artist $artist
     *
     * @return EventArtist
     */
    public function setArtist(\Acted\LegalDocsBundle\Entity\Artist $artist = null)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist
     *
     * @return \Acted\LegalDocsBundle\Entity\Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }
}
