<?php

require_once APPLICATION_ENTITIES . '/Posts.php';

class PostService {
    
    public function submitPost($postarr, $userid){
        // action body
    	try {
	        $exe = Zend_Registry::get("exe");
	        $post = new Posts();
	        $post->setCompanyId($postarr['company_id']);
	        $post->setPostTime(date('Y-m-d H:i:s'));
	        $post->setText($postarr['post_text']);
	        $post->setUserId($userid);
                $post->setAnonymous_flag($postarr['anonymous_flag']);
	        $exe->persist($post);
	        $exe->commit();
	        return true;
    	}
    	catch (Exception $ex) {
            error_log("Post exception:" . $ex->getMessage());
            return false;
        }
    	
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
    
    public function getLatestPost()
    {
    	$exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $query = $em->createQuery('select p from posts p order by post_time desc limit 10 ');
        $itr = $query->iterate();
        $posts = array();
        foreach ($itr as $user) {
            $posts[] =  $user[0];
        }
        return $posts;
    }

}

