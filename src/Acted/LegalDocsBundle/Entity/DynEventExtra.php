<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynEventExtra
 */
class DynEventExtra
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
    private $extraId;

    /**
     * @var integer
     */
    private $eventId;

    /**
     * @var varchar
     */
    private $name;

    /**
     * @var double
     */
    private $price;

    /**
     * @var int
     */
    private $currencyId;

    /**
     * @var varchar
     */
    private $comments;


    /**
     * Set extraId
     *
     * @param integer $extraId
     *
     * @return DynEventExtra
     */
    public function setExtraId($extraId)
    {
        $this->extraId = $extraId;

        return $this;
    }

    /**
     * Get extraId
     *
     * @return integer
     */
    public function getExtraId()
    {
        return $this->extraId;
    }

    /**
     * Set eventId
     *
     * @param integer $eventId
     *
     * @return DynEventExtra
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
     * Set name
     *
     * @param \varchar $name
     *
     * @return DynEventExtra
     */
    public function setName(\varchar $name)
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
     * Set price
     *
     * @param \double $price
     *
     * @return DynEventExtra
     */
    public function setPrice(\double $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return \double
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set currencyId
     *
     * @param \int $currencyId
     *
     * @return DynEventExtra
     */
    public function setCurrencyId(\int $currencyId)
    {
        $this->currencyId = $currencyId;

        return $this;
    }

    /**
     * Get currencyId
     *
     * @return \int
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    /**
     * Set comments
     *
     * @param \varchar $comments
     *
     * @return DynEventExtra
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
}
