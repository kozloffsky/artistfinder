<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefRole
 */
class RefRole
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
    private $roleId;

    /**
     * @var varchar
     */
    private $code;

    /**
     * @var varchar
     */
    private $name;


    /**
     * Set roleId
     *
     * @param \int $roleId
     *
     * @return RefRole
     */
    public function setRoleId(\int $roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Get roleId
     *
     * @return \int
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set code
     *
     * @param \varchar $code
     *
     * @return RefRole
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
     * @return RefRole
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
