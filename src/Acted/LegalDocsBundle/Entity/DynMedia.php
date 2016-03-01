<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynMedia
 */
class DynMedia
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
    private $mediaId;

    /**
     * @var varchar
     */
    private $mediaType;

    /**
     * @var varchar
     */
    private $name;

    /**
     * @var varchar
     */
    private $link;

    /**
     * @var integer
     */
    private $mediaSize;

    /**
     * @var int
     */
    private $position;

    /**
     * @var boolean
     */
    private $active;


    /**
     * Set mediaId
     *
     * @param integer $mediaId
     *
     * @return DynMedia
     */
    public function setMediaId($mediaId)
    {
        $this->mediaId = $mediaId;

        return $this;
    }

    /**
     * Get mediaId
     *
     * @return integer
     */
    public function getMediaId()
    {
        return $this->mediaId;
    }

    /**
     * Set mediaType
     *
     * @param \varchar $mediaType
     *
     * @return DynMedia
     */
    public function setMediaType( $mediaType)
    {
        $this->mediaType = $mediaType;

        return $this;
    }

    /**
     * Get mediaType
     *
     * @return \varchar
     */
    public function getMediaType()
    {
        return $this->mediaType;
    }

    /**
     * Set name
     *
     * @param \varchar $name
     *
     * @return DynMedia
     */
    public function setName( $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return \varchar
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set link
     *
     * @param \varchar $link
     *
     * @return DynMedia
     */
    public function setLink( $link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return \varchar
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set mediaSize
     *
     * @param \integer $mediaSize
     *
     * @return DynMedia
     */
    public function setMediaSize( $mediaSize)
    {
        $this->mediaSize = $mediaSize;

        return $this;
    }

    /**
     * Get mediaSize
     *
     * @return \integer
     */
    public function getMediaSize()
    {
        return $this->mediaSize;
    }

    /**
     * Set position
     *
     * @param \int $position
     *
     * @return DynMedia
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return \int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return DynMedia
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
}
