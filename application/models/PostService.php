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
        return $exe->getMetaDataObject('Posts', $id);
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
    
    public function getMorePost($offset=0, $size=10) {
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $sql = "select p.id, p.text, if(p.anonymous_flag, 'Anonymous', u.firstname) as firstname, if(u.fbuid && p.anonymous_flag=0, concat('http://graph.facebook.com/', u.fbuid, '/picture?type=small'), 'img/people/blank_face.jpg') as profile_photo,c.company_name, count(cm.id) as comments_count 
                from 
                    posts p join users u on u.id=p.user_id
                    join companies c on p.company_id=c.id
                    left join comments cm on p.id=cm.post_id
                GROUP BY p.id    
                ORDER BY p.post_time desc limit $offset,$size";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $data = array();
        foreach($res as $i=>$rec) 
        {
            $data[$i]['id'] = $rec['id'];
            $data[$i]['post_id'] = $rec['id'];
            $data[$i]['text'] = substr($rec['text'], 0, 70).'...';
            $data[$i]['firstname'] = $rec['firstname'];
            $data[$i]['company_name'] = $rec['company_name'];
            $data[$i]['profile_photo'] = $rec['profile_photo'];
            $data[$i]['comments_count'] = $rec['comments_count'];
        }    
        return $data;
    }
    
    public function getMorePostsByUser($user_id, $offset=0, $size=10) {
        
        $posts = array();
        if(!empty($user_id)) {
            $exe = Zend_Registry::get("exe");
            $em = $exe->getMetaDataEntityManager();
            if($offset >= 0) {
                $sql = "select posts.id, posts.text, companies.company_name, date(posts.post_time) as post_time
                    from posts join companies on posts.company_id=companies.id
                    where user_id=$user_id
                    order by posts.post_time desc
                    limit $offset,$size";
            } else {
                $sql = "select posts.id, posts.text, companies.company_name, date(posts.post_time) as post_time
                    from posts join companies on posts.company_id=companies.id
                    where user_id=$user_id
                    order by posts.post_time desc";   
            }
            
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_CLASS);
        }
        
        return $posts;
    }
    
    public function getMorePostsByUserGroupbyMonth($user_id) {
        $posts = $this->getMorePostsByUser($user_id, -1);
        $posts_bymonth = array();
        foreach($posts as $post) {
            $post_time = $post->post_time;
            if(!isset($posts_bymonth[date('F', $post_time)])) {
                $posts_bymonth[date('F', $post_time)] = array();
            }
            $post->post_time = date('F j, Y', strtotime($post_time));
            array_push($posts_bymonth[date('F', $post_time)], $post);
        } 
        return $posts_bymonth;
    }
    
    public function getPostByCompanyName($company_name, $offset=0, $size=10) {
        $posts = array();
        if(!empty($company_name)) {
            $exe = Zend_Registry::get("exe");
            $em = $exe->getMetaDataEntityManager();
            $sql = "select users.firstname, concat(substring(posts.text, 1, 70), '...') as text, posts.post_time, companies.company_name, posts.id as post_id, posts.id as id, count(comments.id) as comments_count
                    from
                    posts join users on (posts.user_id=users.id)
                    join companies on (posts.company_id=companies.id)
                    left join comments on (posts.id=comments.post_id)
                    where
                    companies.company_name like '%$company_name%'
                    group by posts.id
                    order by posts.post_time desc
                    limit $offset, $size";
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $posts = $stmt->fetchAll(PDO::FETCH_CLASS);
        }
        
        return $posts;
        
    }
    
    private function getPrevPostId($id) {
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $sql = "select id from posts where post_time<(select post_time from posts where id=$id) order by post_time desc limit 0,1";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $rec = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if(!empty($rec)) {
            return $rec[0];
        } else {
            return 0;
        }
    }
    
    private function getNextPostId($id) {
        $exe = Zend_Registry::get("exe");
        $em = $exe->getMetaDataEntityManager();
        $sql = "select id from posts where post_time>(select post_time from posts where id=$id) order by post_time limit 0,1";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $rec = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if(!empty($rec)) {
            return $rec[0];
        } else {
            return 0;
        }
    }
    
    public function getPrevNextPostIds($id) {
        $prevnext_postids = array('prev'=>0, 'next'=>0);
        $prev_postid = $this->getPrevPostId($id);
        $next_postid = $this->getNextPostId($id);
        if($prev_postid !==0 ) {
            $prevnext_postids['next'] = $prev_postid; 
        }
        if($next_postid !==0 ) {
            $prevnext_postids['prev'] = $next_postid; 
        }
        return $prevnext_postids;
    }
    

}

