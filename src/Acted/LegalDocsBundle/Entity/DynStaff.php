<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynStaff
 */
class DynStaff
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
    private $userId;

    /**
     * @var int
     */
    private $roleId;

    /**
     * @var varchar
     */
    private $signature;


    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return DynStaff
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set roleId
     *
     * @param \int $roleId
     *
     * @return DynStaff
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
     * Set signature
     *
     * @param \varchar $signature
     *
     * @return DynStaff
     */
    public function setSignature(\varchar $signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature
     *
     * @return \varchar
     */
    public function getSignature()
    {
        return $this->signature;
    }
}
