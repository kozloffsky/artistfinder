<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynArtistRating
 */
class DynArtistRating
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
    private $eventId;

    /**
     * @var integer
     */
    private $artistId;

    /**
     * @var int
     */
    private $rating;

    /**
     * @var varchar
     */
    private $title;

    /**
     * @var varchar
     */
    private $comments;

    /**
     * @var \DateTime
     */
    private $ratingDateTime;


    /**
     * Set eventId
     *
     * @param integer $eventId
     *
     * @return DynArtistRating
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Get eventId
     *
     * @return integer
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Set artistId
     *
     * @param integer $artistId
     *
     * @return DynArtistRating
     */
    public function setArtistId($artistId)
    {
        $this->artistId = $artistId;

        return $this;
    }

    /**
     * Get artistId
     *
     * @return integer
     */
    public function getArtistId()
    {
        return $this->artistId;
    }

    /**
     * Set rating
     *
     * @param \int $rating
     *
     * @return DynArtistRating
     */
    public function setRating(\int $rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return \int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set title
     *
     * @param \varchar $title
     *
     * @return DynArtistRating
     */
    public function setTitle(\varchar $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return \varchar
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set comments
     *
     * @param \varchar $comments
     *
     * @return DynArtistRating
     */
    public function setComments(\varchar $comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return \varchar
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set ratingDateTime
     *
     * @param \DateTime $ratingDateTime
     *
     * @return DynArtistRating
     */
    public function setRatingDateTime($ratingDateTime)
    {
        $this->ratingDateTime = $ratingDateTime;

        return $this;
    }

    /**
     * Get ratingDateTime
     *
     * @return \DateTime
     */
    public function getRatingDateTime()
    {
        return $this->ratingDateTime;
    }
}
