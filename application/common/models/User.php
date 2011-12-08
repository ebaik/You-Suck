<?php

/**
 * @Entity
 * @Table(name="users", indexes={@index(name="email_idx", columns={"email"}), @index(name="id_idx", columns={"id"})})
 */
class User
{
     /**
     * @Id @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(name="lastname", length=50, nullable="true")
     */
    private $lastname;

    /**
     * @Column(name="fbuid", length=50, nullable="true")
     */
    private $fbuid;

    /**
     * @Column(name="firstname", length=50, nullable="true")
     */
    private $firstname;

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

    /** @Column(name="registration_time", type="string", nullable="true") */
    private $registration_time;

    /** @Column(name="username", type="string", nullable="true") */
	private $username;
	
	/** @Column(name="logo_file_name", type="string", nullable="true") */
	private $logofilename;

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

    public function setRegistrationTime($registration_time)
    {
        $this->registration_time = $registration_time;
        
    }

    public function getRegistrationTime()
    {
        return $this->registration_time;
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

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->lastname;
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

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    public function getZip()
    {
        return $this->zip;
    }
    
    public function setUsername($username)
    {
    	$this->zip = $username;
    }
    
    public function getUsername()
    {
    	return $this->username;
    }

    public function setLogofilename($logofilename)
    {
    	$this->zip = $logofilename;
    }
    
    public function getLogofilename()
    {
    	return $this->logofilename;
    }
    
    public function setFbuid($fbuid)
    {
        $this->fbuid = $fbuid;
    }

    public function getFbuid()
    {
        return $this->fbuid;
    }


}
