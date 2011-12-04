<?php

class PostService {
    
    public  function postUser($postarr, $userid){
        // action body
        $exe = Zend_Registry::get("exe");
        $post = new Posts();
        $post->setCompanyId($postarr['company_id']);
        $post->setCreatedAt($postarr['post_time']);
        $post->setText($postarr['text']);
        $post->setUserId($userid);
        $exe->persist($post);
        $exe->commit();

    }

    public function getPost($id){
        $exe = Zend_Registry::get("exe");
        return $exe->getMetaDataObject('Post', $id);
    }

    public function getPostByUser($userid){
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery('select p from posts p where p.user_id = :user_id')->setParameter('user_id', $userid);
        $itr = $query->iterate();
        $posts = array();
        foreach ($itr as $user) {
            $posts[] =  $user[0];
        }
        return $posts;
    }

    public function getPostByCompany($company_id){
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery('select p from posts p where p.company_id = :company_id')->setParameter('company_id', $company_id);
        $itr = $query->iterate();
        $posts = array();
        foreach ($itr as $user) {
            $posts[] =  $user[0];
        }
        return $posts;
    }
}

