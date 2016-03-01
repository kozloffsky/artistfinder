<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * RefRoleRight
 */
class RefRoleRight
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $roleId;

    /**
     * @var integer
     */
    private $rightId;


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
     * Set roleId
     *
     * @param integer $roleId
     *
     * @return RefRoleRight
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Get roleId
     *
     * @return integer
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set rightId
     *
     * @param integer $rightId
     *
     * @return RefRoleRight
     */
    public function setRightId($rightId)
    {
        $this->rightId = $rightId;

        return $this;
    }

    /**
     * Get rightId
     *
     * @return integer
     */
    public function getRightId()
    {
        return $this->rightId;
    }
}
