<?php

require_once 'BaseController.php';

require_once APPLICATION_ENTITIES . '/Posts.php';
require_once APPLICATION_ENTITIES . '/User.php';
require_once APPLICATION_ENTITIES . '/Companies.php';
require_once APPLICATION_MODELS . '/UserService.php';
require_once APPLICATION_MODELS . '/CompanyService.php';
require_once APPLICATION_MODELS . '/PostService.php';

class IndexController extends BaseController
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	try{
	    	$exe = Zend_Registry::get("exe");
	        $em = $exe->getMetaDataEntityManager();
	        $query = $em->createQuery('select p.text, u.firstname, u.lastname from posts p, user u where u.id = p.user_id ORDER BY p.post_time desc ')->setMaxResults(10);
	        $itr = $query->iterate();
	        $i = 0;
	        foreach ($itr as $res) {
	        	$posts[$i]['post_text'] =  $res[$i]['text'];
	            $fullname = array();
		        if(!empty($res[$i]['firstname']))
		    	   	$fullname[] = $res[$i]['firstname'];
		       	if(!empty($res[$i]['lastname']))
		       		$fullname[] = $res[$i]['lastname'];
		       	$name = implode(' ', $fullname);
		       	$posts[$i]['name'] =  $name;
	            $i++;
	        }
	        $this->view->posts = $posts;
	       
    	}
    	catch (Exception $ex) {
            error_log("Index exception:" . $ex->getMessage());
            return false;
        }
    	
        /*
        var_dump($itr);
        exit;
        $posts = array();
        foreach ($itr as $user) {
            $posts[] =  $user[0];
        }
        return $posts;
        */
    }


}

