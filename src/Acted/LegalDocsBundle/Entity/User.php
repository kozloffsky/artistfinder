<?php

namespace Acted\LegalDocsBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface, \Serializable
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
     * @var string
     */
    private $tempPassword;

    /**
     * @var boolean
     */
    private $active = false;

    /**
     * @var boolean
     */
    private $fake = false;

    /**
     * @var \DateTime
     */
    private $createdAt;

    private $user;

    /**
     * @var string
     */
    private $postcode = '';

    /**
     * @var \Acted\LegalDocsBundle\Entity\Profile
     */
    private $profile;


    /**
     * @var string
     */
    private $avatar;

    /**
     * @var string
     */
    private $background;

    /**
     * @var \Acted\LegalDocsBundle\Entity\Artist
     */
    private $artist;

    /**
     * @var \Acted\LegalDocsBundle\Entity\PaymentSetting
     */
    private $paymentSetting;

    /**
     * @var string
     */
    private $confirmationToken;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $roles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $chatRoomsArtist;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $chatRoomsClient;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $passwordRequestedAt;

    /**
     * @var string
     */
    private $confirmationPeriod;

    /**
     * @var Client
     */
    private $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->chatRoomsArtist = new \Doctrine\Common\Collections\ArrayCollection();
        $this->chatRoomsClient = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     *
     * @return User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Add role
     *
     * @param \Acted\LegalDocsBundle\Entity\RefRole $role
     *
     * @return User
     */
    public function addRole(\Acted\LegalDocsBundle\Entity\RefRole $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \Acted\LegalDocsBundle\Entity\RefRole $role
     */
    public function removeRole(\Acted\LegalDocsBundle\Entity\RefRole $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Add chatRoom
     *
     * @param \Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom
     *
     * @return User
     */
    public function addChatRoomArtist(\Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom)
    {
        $this->chatRoomsArtist[] = $chatRoom;

        return $this;
    }

    /**
     * Remove chatRoom
     *
     * @param \Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom
     */
    public function removeChatRoomArtist(\Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom)
    {
        $this->chatRoomsArtist->removeElement($chatRoom);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getChatRoomsArtist()
    {
        return $this->chatRoomsArtist;
    }

    /**
     * Add chatRoom
     *
     * @param \Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom
     *
     * @return User
     */
    public function addChatRoomClient(\Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom)
    {
        $this->chatRoomsClient[] = $chatRoom;

        return $this;
    }

    /**
     * Remove chatRoom
     *
     * @param \Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom
     */
    public function removeChatRoomClient(\Acted\LegalDocsBundle\Entity\ChatRoom $chatRoom)
    {
        $this->chatRoomsClient->removeElement($chatRoom);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getChatRoomsClient()
    {
        return $this->chatRoomsClient;
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
     * Set passwordRequestedAt
     *
     * @param \DateTime $passwordRequestedAt
     *
     * @return User
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    /**
     * Get passwordRequestedAt
     *
     * @return \DateTime
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    public function isPasswordRequestNonExpired($ttl, $confPeriod)
    {
        if (!$this->getConfirmationPeriod()) {
            $result = $this->getPasswordRequestedAt() instanceof \DateTime &&
                $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
        } else {
            $result = $this->getConfirmationPeriod() instanceof \DateTime &&
                $this->getConfirmationPeriod()->getTimestamp() + $confPeriod > time();
        }

        return $result;
    }

    public function getFullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->passwordHash,
            $this->firstname,
            $this->lastname,
            $this->primaryPhone,
        ]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->passwordHash,
            $this->firstname,
            $this->lastname,
            $this->primaryPhone,
        ) = unserialize($serialized);
    }

    /**
     * @return boolean
     */
    public function isFake()
    {
        return $this->fake;
    }

    /**
     * @param boolean $fake
     */
    public function setFake($fake)
    {
        $this->fake = $fake;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getConfirmationPeriod()
    {
        return $this->confirmationPeriod;
    }

    /**
     * @param \DateTime $confirmationPeriod
     */
    public function setConfirmationPeriod($confirmationPeriod)
    {
        $this->confirmationPeriod = $confirmationPeriod;
    }

    public function getUserEmail()
    {
        return $this->getEmail()?$this->getEmail():'';
    }

    /**
     * @return string
     */
    public function getTempPassword()
    {
        return $this->tempPassword;
    }

    /**
     * @param string $tempPassword
     */
    public function setTempPassword($tempPassword)
    {
        $this->tempPassword = $tempPassword;
    }

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

        if (!empty($this->getProfile())) {
            $this->getProfile()->setActive($active);
        }

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
     * Set postcode
     *
     * @param string $postcode
     *
     * @return User
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar =  '/' . $avatar;

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
     * Set paymentSetting
     *
     * @param \Acted\LegalDocsBundle\Entity\PaymentSetting $paymentSetting
     *
     * @return User
     */
    public function setPaymentSetting(\Acted\LegalDocsBundle\Entity\PaymentSetting $paymentSetting = null)
    {
        $this->paymentSetting = $paymentSetting;

        return $this;
    }

    /**
     * Get paymentSetting
     *
     * @return \Acted\LegalDocsBundle\Entity\PaymentSetting
     */
    public function getProfilePaymentSetting()
    {
        return $this->paymentSetting;
    }

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

    /**
     * Returns the roles granted to the user.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $roles =  $this->roles->map(function($entry) { /** @var RefRole $entry */
            return $entry->getCode();
        });
        return $roles->toArray();
    }

    /**
     * @return string
     */
    public function getRoleName()
    {
        $roles =  $this->roles->map(function($entry) { /** @var RefRole $entry */
            return $entry->getName();
        });
        return $roles->first();
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->getPasswordHash();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    /**
     * Get fake
     *
     * @return boolean
     */
    public function getFake()
    {
        return $this->fake;
    }

    /**
     * Get paymentSetting
     *
     * @return \Acted\LegalDocsBundle\Entity\PaymentSetting
     */
    public function getPaymentSetting()
    {
        return $this->paymentSetting;
    }

    /**
     * Add chatRoomsArtist
     *
     * @param \Acted\LegalDocsBundle\Entity\ChatRoom $chatRoomsArtist
     *
     * @return User
     */
    public function addChatRoomsArtist(\Acted\LegalDocsBundle\Entity\ChatRoom $chatRoomsArtist)
    {
        $this->chatRoomsArtist[] = $chatRoomsArtist;

        return $this;
    }

    /**
     * Remove chatRoomsArtist
     *
     * @param \Acted\LegalDocsBundle\Entity\ChatRoom $chatRoomsArtist
     */
    public function removeChatRoomsArtist(\Acted\LegalDocsBundle\Entity\ChatRoom $chatRoomsArtist)
    {
        $this->chatRoomsArtist->removeElement($chatRoomsArtist);
    }

    /**
     * Add chatRoomsClient
     *
     * @param \Acted\LegalDocsBundle\Entity\ChatRoom $chatRoomsClient
     *
     * @return User
     */
    public function addChatRoomsClient(\Acted\LegalDocsBundle\Entity\ChatRoom $chatRoomsClient)
    {
        $this->chatRoomsClient[] = $chatRoomsClient;

        return $this;
    }

    /**
     * Remove chatRoomsClient
     *
     * @param \Acted\LegalDocsBundle\Entity\ChatRoom $chatRoomsClient
     */
    public function removeChatRoomsClient(\Acted\LegalDocsBundle\Entity\ChatRoom $chatRoomsClient)
    {
        $this->chatRoomsClient->removeElement($chatRoomsClient);
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }


}
