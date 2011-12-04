<?php

/**
 * @Entity
 * @Table(name="posts", indexes={@index(name="user_id_idx", columns={"user_id"}), @index(name="company_id_idx", columns={"company_id"}), @index(name="id_idx", columns={"id"})})
 */
class Posts
{
     /**
     * @Id @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(name="text",nullable="true")
     */
    private $text;

    /**
     * @Column(name="user_id", type="integer", nullable="true")
     */
    private $user_id;

    /**
     * @Column(name="company_id", type="integer", nullable="true")
     */
    private $company_id;

    /** @Column(name="post_time", type="date", nullable="true") */
    private $createdAt;

    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }

    public function getCompanyId()
    {
        return $this->company_id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
