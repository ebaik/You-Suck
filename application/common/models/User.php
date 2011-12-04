<?php

/**
 * @Entity
 * @Table(name="user", indexes={@index(name="email_idx", columns={"email"}), @index(name="id_idx", columns={"id"})})
 */
class User
{
     /**
     * @Id @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(name="fbUID",nullable="true")
     */
    private $fbUID;

    /**
     * @Column(name="fullname", length=50, nullable="true")
     */
    private $fullname;

    /**
     * @Column(name="username", length=50, nullable="true")
     */
    private $username;

    /**
     * @Column(name="domain", length=50, nullable="true")
     */
    private $domain;

    /**
     * @Column(name="zip", length=50, nullable="true")
     */
    private $zip;

    /**
     * @Column(name="city", length=50, nullable="true")
     */
    private $city;

    /**
     * @Column(name="state", length=50, nullable="true")
     */
    private $state;

    /**
     * @Column(name="country", length=50, nullable="true")
     */
    private $country;

    /**
     * @Column(name="address", length=50, nullable="true")
     */
    private $address;

    /**
     * @Column(name="phone", length=50, nullable="true")
     */
    private $phone;

    /** @Column(name="email", length=100) */
    private $email;

    /** @Column(name="password", length=50) */
    private $password;

    /** @Column(name="registration_time", type="date", nullable="true") */
    private $createdAt;


    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setFbUID($fbUID)
    {
        $this->fbUID = $fbUID;
    }

    public function getFbUID()
    {
        return $this->fbUID;
    }

    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    public function getZip()
    {
        return $this->zip;
    }
}
