<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynClient
 */
class DynClient
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
     * @var varchar
     */
    private $clientType;

    /**
     * @var varchar
     */
    private $company;

    /**
     * @var varchar
     */
    private $comments;

    /**
     * @var varchar
     */
    private $address;

    /**
     * @var int
     */
    private $cityId;


    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return DynClient
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
     * Set clientType
     *
     * @param \varchar $clientType
     *
     * @return DynClient
     */
    public function setClientType(\varchar $clientType)
    {
        $this->clientType = $clientType;

        return $this;
    }

    /**
     * Get clientType
     *
     * @return \varchar
     */
    public function getClientType()
    {
        return $this->clientType;
    }

    /**
     * Set company
     *
     * @param \varchar $company
     *
     * @return DynClient
     */
    public function setCompany(\varchar $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \varchar
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set comments
     *
     * @param \varchar $comments
     *
     * @return DynClient
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
     * Set address
     *
     * @param \varchar $address
     *
     * @return DynClient
     */
    public function setAddress(\varchar $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \varchar
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set cityId
     *
     * @param \int $cityId
     *
     * @return DynClient
     */
    public function setCityId(\int $cityId)
    {
        $this->cityId = $cityId;

        return $this;
    }

    /**
     * Get cityId
     *
     * @return \int
     */
    public function getCityId()
    {
        return $this->cityId;
    }
}
