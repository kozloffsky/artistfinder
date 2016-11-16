<?php

namespace Acted\LegalDocsBundle\Popo;

final class RegisterUser
{
    private $role;
    private $firstname;
    private $lastname;
    private $email;
    private $password;
    private $categories;
    private $name;
    private $country;
    private $phone;
    private $city;
    private $fake;
    private $tempPassword;
    private $cityLat;
    private $cityLng;
    private $regionLat;
    private $regionLng;
    private $regionName;

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getFake()
    {
        return $this->fake;
    }

    /**
     * @param mixed $fake
     */
    public function setFake($fake)
    {
        $this->fake = $fake;
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
     * @return string
     */
    public function getCityLat()
    {
        return $this->cityLat;
    }

    /**
     * @param string $cityLat
     */
    public function setCityLat($cityLat)
    {
        $this->cityLat = $cityLat;
    }

    /**
     * @return string
     */
    public function getCityLng()
    {
        return $this->cityLng;
    }

    /**
     * @param string $cityLng
     */
    public function setCityLng($cityLng)
    {
        $this->cityLng = $cityLng;
    }

    /**
     * @return string
     */
    public function getRegionLat()
    {
        return $this->regionLat;
    }

    /**
     * @param string $regionLat
     */
    public function setRegionLat($regionLat)
    {
        $this->regionLat = $regionLat;
    }

    /**
     * @return string
     */
    public function getRegionLng()
    {
        return $this->regionLng;
    }

    /**
     * @param string $regionLng
     */
    public function setRegionLng($regionLng)
    {
        $this->regionLng = $regionLng;
    }

    /**
     * @return string
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * @param string $regionName
     */
    public function setRegionName($regionName)
    {
        $this->regionName = $regionName;
    }
}