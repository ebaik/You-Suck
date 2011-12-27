<?php

require_once 'BaseController.php';
require_once APPLICATION_ENTITIES . '/Posts.php';
require_once APPLICATION_ENTITIES . '/User.php';
require_once APPLICATION_ENTITIES . '/Companies.php';
require_once APPLICATION_MODELS . '/UserService.php';
require_once APPLICATION_MODELS . '/CompanyService.php';
require_once APPLICATION_MODELS . '/PostService.php';
require_once APPLICATION_MODELS . '/CommentService.php';

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
	$company_name = trim($this->_getParam('company_name'));
	$synopsys = trim($this->_getParam('synopsys'));
        $name = trim($this->_getParam('name'));
        $email = trim($this->_getParam('email'));
        $check_anonymous = trim($this->_getParam('check_anonymous'));
	// get user info
        // if the user doesnt login, use the anonymous user
        $user_obj = UserService::getLoggedInUser();
        if(!isset($user_obj)) {
            $exe = Zend_Registry::get("exe");
            $user_obj = $exe->getGlobalUserObject();
            
            // if the user doesnt login
            // take the name and email and insert them if we havent
            if(!empty($name) && !empty($email)) 
            {
                $userService = new UserService();
                $user_obj = $userService->getByEmail($email);
                if(!$user_obj) 
                {
                    $arr['email'] = $email;
                    $arr['first_name'] = $name;
                    $arr['password'] = '';
                    $user_obj = $userService->createUser($arr);
                }
            } else {
                echo '0';
                exit;
            }
            
        }
	

        $cs = new CompanyService();
        //$company_name = 'delta';
        $company_obj = $cs->getCompanyByName($company_name);
        // temp solution
        // if the company doesnt exist in the companies table,
        // we insert it into the companies table
        if(!isset($company_obj)) {
            $arr['company_name'] = $company_name;
            $arr['industry'] = '';
            $arr['phone_number'] = '';
            $cs->createCompany($arr);
        }
	$company_obj = $cs->getCompanyByName($company_name);
        
        $ps = new PostService();
        $postarr['company_id'] = $company_obj->getId(); 
        $postarr['post_text'] = $synopsys; 
        $postarr['anonymous_flag'] = $check_anonymous;error_log('check_anonymous', $check_anonymous);
        
        $res = $ps->submitPost($postarr, $user_obj->getId());
        echo $res;
        exit;
       	
	}
    
    public function searchAction()
    {
        $query = trim($this->_getParam('query'));
        $offset = $this->_getParam('offset');
        if(!isset($offset)) {
            $offset = 0;
        }
        $ps = new PostService();
        $posts = $ps->getPostByCompanyName($query, $offset);

        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        echo json_encode($posts);
		
    }
    
    public function showAction()
    {
        
    }
    
    public function itemAction()
    {
        $id = $this->_getParam('id');
        if(isset($id)) 
        {
            $ps = new PostService();
            $post = $ps->getPost($id);
            $cs = new CommentService();
            $comments = $cs->getCommentsByPostId($id);
            $this->view->post = $post;
            $this->view->comments = $comments;
        } 
        else 
        {
            
        }
    }
    
    public function postcommentAction() {
        $post_id = $this->_getParam('post_id');
        $content = $this->_getParam('content');
        $user = UserService::getLoggedInUser();
        $author_id = $user->getId();
        
        $cs = new CommentService();
        $cs->create($content, $author_id, $post_id);
        
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(TRUE);
        
        echo json_encode(array('status'=>1, 'firstname'=>$user->getFirstName()));
    }
    
    public function mypostAction() {
        $user = UserService::getLoggedInUser();
        $user_id = $user->getId();
        $ps = new PostService;
        $posts = $ps->getMorePostsByUser($user_id);
        $this->view->user = $user;
        $this->view->posts = $posts;
    }
    
    
}
