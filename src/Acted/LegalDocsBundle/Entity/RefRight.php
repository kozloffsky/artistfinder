<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefRight
 */
class RefRight
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
     * @var int
     */
    private $rightId;

    /**
     * @var varchar
     */
    private $code;

    /**
     * @var varchar
     */
    private $name;


    /**
     * Set rightId
     *
     * @param \int $rightId
     *
     * @return RefRight
     */
    public function setRightId(\int $rightId)
    {
        $this->rightId = $rightId;

        return $this;
    }

    /**
     * Get rightId
     *
     * @return \int
     */
    public function getRightId()
    {
        return $this->rightId;
    }

    /**
     * Set code
     *
     * @param \varchar $code
     *
     * @return RefRight
     */
    public function setCode(\varchar $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return \varchar
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param \varchar $name
     *
     * @return RefRight
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
}
