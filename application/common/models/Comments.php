<?php

/**
 * @Entity
 * 
 */
class Comments
{
     /**
     * @Id @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(name="content",nullable="true")
     */
    private $content;

    /**
     * @Column(name="author_id", type="integer", nullable="false")
     */
    private $author_id;
    
    /**
     * @Column(name="post_id", type="integer", nullable="false")
     */
    private $post_id;

    /** @Column(name="created", type="string", nullable="false") */
    private $created;
    
    /** @Column(name="updated", type="string", nullable="false") */
    private $updated;
    
    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
    }

    public function getAuthorId()
    {
        return $this->author_id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
    
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

    public function getPostId()
    {
        return $this->post_id;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getCreated()
    {
        return $this->created;
    }
    
    public function setUpdated($updated)
    {
    	$this->updated = $updated;
    }
    
    public function getUpdated()
    {
    	return $this->updated;
    }
}
