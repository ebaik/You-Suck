
<?php

require_once APPLICATION_ENTITIES . '/Comments.php';

class CommentService {
    
    private $exe;
    
    private $em;
    
    public function __construct() {
        $this->exe = Zend_Registry::get("exe");
        $this->em = $this->exe->getMetaDataEntityManager();
    }
    
    public function create($content, $author_id, $post_id) {
        if(!empty($content) && !empty($author_id) && !empty($post_id)) {
            $created = date('Y-m-d H:i:s');
            $updated = $created;
            $sql = "insert into comments(content, author_id, post_id, created, updated) 
                    values('$content', $author_id, $post_id, '$created', '$updated')";
            
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            return true;
        } else {
            return false;
        }
        
    }
    
    // fields returned:
    // content
    // ceated time of content
    // firstname of author
    public function getCommentsByPostId($post_id) {
        $comments = array();
        if(!empty($post_id)) {
            $sql = "select c.content, c.created, u.firstname 
                    from comments c join users u on (c.author_id=u.id) 
                    where c.post_id=$post_id";
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_CLASS);
        }
        
        return $comments;
    }
    
    
//    public function submitPost($postarr, $userid){
//        // action body
//    	try {
//	        $exe = Zend_Registry::get("exe");
//	        $post = new Posts();
//	        $post->setCompanyId($postarr['company_id']);
//	        $post->setPostTime(date('Y-m-d H:i:s'));
//	        $post->setText($postarr['post_text']);
//	        $post->setUserId($userid);
//                $post->setAnonymous_flag($postarr['anonymous_flag']);
//	        $exe->persist($post);
//	        $exe->commit();
//	        return true;
//    	}
//    	catch (Exception $ex) {
//            error_log("Post exception:" . $ex->getMessage());
//            return false;
//        }
//    	
//    }
//
//    public function getPost($id){
//        $exe = Zend_Registry::get("exe");
//        return $exe->getMetaDataObject('Post', $id);
//    }
//
//    public function getPostByUser($userid){
//        $exe = Zend_Registry::get("exe");
//        $em = $exe->getMetaDataEntityManager();
//        $query = $em->createQuery('select p from posts p where p.user_id = :user_id')->setParameter('user_id', $userid);
//        $itr = $query->iterate();
//        $posts = array();
//        foreach ($itr as $user) {
//            $posts[] =  $user[0];
//        }
//        return $posts;
//    }
//
//    public function getPostByCompany($company_id){
//        $exe = Zend_Registry::get("exe");
//        $em = $exe->getMetaDataEntityManager();
//        $query = $em->createQuery('select p from posts p where p.company_id = :company_id')->setParameter('company_id', $company_id);
//        $itr = $query->iterate();
//        $posts = array();
//        foreach ($itr as $user) {
//            $posts[] =  $user[0];
//        }
//        return $posts;
//    }
//    
//    public function getLatestPost()
//    {
//    	$exe = Zend_Registry::get("exe");
//        $em = $exe->getMetaDataEntityManager();
//        $query = $em->createQuery('select p from posts p order by post_time desc limit 10 ');
//        $itr = $query->iterate();
//        $posts = array();
//        foreach ($itr as $user) {
//            $posts[] =  $user[0];
//        }
//        return $posts;
//    }
//    
//    public function getMorePost($offset=0, $size=10) {
//        $exe = Zend_Registry::get("exe");
//        $em = $exe->getMetaDataEntityManager();
//        $sql = "select p.text, if(p.anonymous_flag, 'Anonymous', u.firstname) as firstname, c.company_name 
//                from 
//                    posts p join users u on u.id=p.user_id
//                    join companies c on p.company_id=c.id
//                ORDER BY p.post_time desc limit $offset,$size";
//        $stmt = $em->getConnection()->prepare($sql);
//        $stmt->execute();
//        $res = $stmt->fetchAll();
//        $data = array();
//        foreach($res as $i=>$rec) 
//        {
//            $data[$i]['text'] = substr($rec['text'], 0, 70).'...';
//            $data[$i]['firstname'] = $rec['firstname'];
//            $data[$i]['company_name'] = $rec['company_name'];
//        }    
//        return $data;
//    }

}



