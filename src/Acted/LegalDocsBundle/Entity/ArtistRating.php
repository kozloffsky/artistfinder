<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * ArtistRating
 */
class ArtistRating
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $eventId;

    /**
     * @var integer
     */
    private $artistId;

    /**
     * @var integer
     */
    private $rating;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $comments;

    /**
     * @var \DateTime
     */
    private $ratingDateTime;


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
     * Set eventId
     *
     * @param integer $eventId
     *
     * @return ArtistRating
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
     * @return ArtistRating
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
     * @param integer $rating
     *
     * @return ArtistRating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ArtistRating
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return ArtistRating
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
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
     * @return ArtistRating
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
