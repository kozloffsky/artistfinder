<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * Homespotlight
 */
class Homespotlight
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var boolean
     */
    private $active = true;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Media
     */
    private $media;


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
     * Set active
     *
     * @param boolean $active
     *
     * @return Homespotlight
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set media
     *
     * @param \Acted\LegalDocsBundle\Entity\Media $media
     *
     * @return Homespotlight
     */
    public function setMedia(\Acted\LegalDocsBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \Acted\LegalDocsBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }
}
