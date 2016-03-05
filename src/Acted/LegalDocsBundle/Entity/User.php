<?php

namespace Acted\LegalDocsBundle\Entity;

/**
 * User
 */
class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $passwordHash;

    /**
     * @var string
     */
    private $primaryPhone;

    /**
     * @var string
     */
    private $secondaryPhone;

    /**
     * @var boolean
     */
    private $active;


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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set passwordHash
     *
     * @param string $passwordHash
     *
     * @return User
     */
    public function setPasswordHash($passwordHash)
    {
        $this->passwordHash = $passwordHash;

        return $this;
    }

    /**
     * Get passwordHash
     *
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * Set primaryPhone
     *
     * @param string $primaryPhone
     *
     * @return User
     */
    public function setPrimaryPhone($primaryPhone)
    {
        $this->primaryPhone = $primaryPhone;

        return $this;
    }

    /**
     * Get primaryPhone
     *
     * @return string
     */
    public function getPrimaryPhone()
    {
        return $this->primaryPhone;
    }

    /**
     * Set secondaryPhone
     *
     * @param string $secondaryPhone
     *
     * @return User
     */
    public function setSecondaryPhone($secondaryPhone)
    {
        $this->secondaryPhone = $secondaryPhone;

        return $this;
    }

    /**
     * Get secondaryPhone
     *
     * @return string
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
     * @return User
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
    /**
     * @var string
     */
    private $avatar;

    /**
     * @var string
     */
    private $background;


    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->rel2abs($this->avatar);
    }

    /**
     * Set background
     *
     * @param string $background
     *
     * @return User
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        return $this->rel2abs($this->background);
    }
    /**
     * @var \Acted\LegalDocsBundle\Entity\Profile
     */
    private $profile;


    /**
     * Set profile
     *
     * @param \Acted\LegalDocsBundle\Entity\Profile $profile
     *
     * @return User
     */
    public function setProfile(\Acted\LegalDocsBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \Acted\LegalDocsBundle\Entity\Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }
    /**
     * @var \Acted\LegalDocsBundle\Entity\Artist
     */
    private $artist;


    /**
     * Set artist
     *
     * @param \Acted\LegalDocsBundle\Entity\Artist $artist
     *
     * @return User
     */
    public function setArtist(\Acted\LegalDocsBundle\Entity\Artist $artist = null)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist
     *
     * @return \Acted\LegalDocsBundle\Entity\Artist
     */
    public function getArtist()
    {
        return $this->artist;
    }

    public function __toString()
    {
        return $this->getEmail();
    }

    protected  function rel2abs($link)
    {
        if(strpos($link, 'http') === 0){
            return $link;
        }
        return '/'.ltrim($link, '/');
    }

}
