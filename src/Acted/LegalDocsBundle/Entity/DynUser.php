<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * DynUser
 */
class DynUser
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
    private $firstname;

    /**
     * @var varchar
     */
    private $lastname;

    /**
     * @var varchar
     */
    private $email;

    /**
     * @var varchar
     */
    private $passwordHash;

    /**
     * @var varchar
     */
    private $primaryPhone;

    /**
     * @var varchar
     */
    private $secondaryPhone;

    /**
     * @var boolean
     */
    private $active;


    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return DynUser
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
     * Set firstname
     *
     * @param \varchar $firstname
     *
     * @return DynUser
     */
    public function setFirstname(\varchar $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return \varchar
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param \varchar $lastname
     *
     * @return DynUser
     */
    public function setLastname(\varchar $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return \varchar
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param \varchar $email
     *
     * @return DynUser
     */
    public function setEmail(\varchar $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return \varchar
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set passwordHash
     *
     * @param \varchar $passwordHash
     *
     * @return DynUser
     */
    public function setPasswordHash(\varchar $passwordHash)
    {
        $this->passwordHash = $passwordHash;

        return $this;
    }

    /**
     * Get passwordHash
     *
     * @return \varchar
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * Set primaryPhone
     *
     * @param \varchar $primaryPhone
     *
     * @return DynUser
     */
    public function setPrimaryPhone(\varchar $primaryPhone)
    {
        $this->primaryPhone = $primaryPhone;

        return $this;
    }

    /**
     * Get primaryPhone
     *
     * @return \varchar
     */
    public function getPrimaryPhone()
    {
        return $this->primaryPhone;
    }

    /**
     * Set secondaryPhone
     *
     * @param \varchar $secondaryPhone
     *
     * @return DynUser
     */
    public function setSecondaryPhone(\varchar $secondaryPhone)
    {
        $this->secondaryPhone = $secondaryPhone;

        return $this;
    }

    /**
     * Get secondaryPhone
     *
     * @return \varchar
     */
    public function getSecondaryPhone()
    {
        return $this->secondaryPhone;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return DynUser
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
