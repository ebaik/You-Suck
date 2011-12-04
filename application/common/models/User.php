<?php

/**
 * @Entity
 * @Table(name="User", indexes={@index(name="email_idx", columns={"email"}), @index(name="id_idx", columns={"id"})})
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
     * @Column(name="name", length=50, nullable="true")
     */
    private $name;

    /** @Column(name="email", length=100) */
    private $email;

    /** @Column(name="password", length=50) */
    private $password;

    /** @Column(name="createdAt", type="date", nullable="true") */
    private $createdAt;


    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
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

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
