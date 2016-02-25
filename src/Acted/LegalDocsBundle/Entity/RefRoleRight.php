<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefRoleRight
 */
class RefRoleRight
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
     * @var int
     */
    private $rightId;


    /**
     * Set roleId
     *
     * @param \int $roleId
     *
     * @return RefRoleRight
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
     * Set rightId
     *
     * @param \int $rightId
     *
     * @return RefRoleRight
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
}
