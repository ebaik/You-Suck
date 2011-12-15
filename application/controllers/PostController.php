<?php

require_once 'BaseController.php';
require_once APPLICATION_ENTITIES . '/Posts.php';
require_once APPLICATION_ENTITIES . '/User.php';
require_once APPLICATION_ENTITIES . '/Companies.php';
require_once APPLICATION_MODELS . '/UserService.php';
require_once APPLICATION_MODELS . '/CompanyService.php';
require_once APPLICATION_MODELS . '/PostService.php';

class PostController extends BaseController
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function editAction()
    {
    
    }
    
    public function submitAction()
    {
		$company_name = trim($this->_getParam('company'));
		$synopsys = trim($this->_getParam('synopsys'));
		//$synopsys = 'test post';
		$exe = Zend_Registry::get("exe");
        $user_obj = $exe->getGlobalUserObject();

        $cs = new CompanyService();
        $company_name = 'delta';
        $company_obj = $cs->getCompanyByName($company_name);
		
        $ps = new PostService();
        $postarr['company_id'] = $company_obj->getId(); 
        $postarr['post_text'] = $synopsys; 
        
        $res = $ps->submitPost($postarr, $user_obj->getId());
        echo $res;
        exit;
       	
	}
    
    public function searchAction()
    {
		$query = trim($this->_getParam('query'));
		$exe = Zend_Registry::get("exe");
		$em = $exe->getMetaDataEntityManager();
		$sql = " select u.firstname, u.lastname,  p.text,  p.post_time from posts p, user u where p.user_id = u.id and p.text like '%$query%' ";
		
		$output = array();
     	
     	try{
			$sql_res = $em->createQuery($sql);
	        $itr = $sql_res->iterate();
	        $i = 0;
	        foreach ($itr as $res) {
	        	if(!empty($res[$i]['text']))
	        	{
		        	$fullname = array();
		        	if(!empty($res[$i]['firstname']))
		        		$fullname[] = $res[$i]['firstname'];
//		        	if(!empty($res[$i]['lastname']))
//		        		$fullname[] = $res[$i]['lastname'];
		        	$name = implode(' ', $fullname);
		        	$output[] = array('fullname'=>$name, 'text'=>$res[$i]['text'], 'post_time'=>$res[$i]['post_time']);
		        	
	        	}
	        	$i ++;
	        }
		}
    	catch (Exception $ex){
			error_log("Post controller exception:" . $ex->getMessage());
		}
		
		$return_json = $this->_helper->json($output);
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		echo $return_json;
		
    }
    
    public function showAction()
    {
        
    }
}
