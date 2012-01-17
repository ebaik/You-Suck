<?php

require_once 'BaseController.php';
require_once APPLICATION_ENTITIES . '/Posts.php';
require_once APPLICATION_ENTITIES . '/User.php';
require_once APPLICATION_ENTITIES . '/Companies.php';
require_once APPLICATION_MODELS . '/UserService.php';
require_once APPLICATION_MODELS . '/CompanyService.php';
require_once APPLICATION_MODELS . '/PostService.php';
require_once APPLICATION_MODELS . '/CommentService.php';
require_once APPLICATION_COMMON.'/Mailer.php';

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
        $company_name = trim($this->_getParam('query'));
        $this->view->company_name = $company_name;
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
            $company_service = new CompanyService();
            $company = $company_service->getCompany($post->getCompanyId());
            $prevnext_postids = $ps->getPrevNextPostIds($id);
            $this->view->post = $post;
            $this->view->comments = $comments;
            $this->view->company = $company;
            $this->view->prevnext_postids = $prevnext_postids;
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
        $author_firstname = $user->getFirstName();
        
        $cs = new CommentService();
        $cs->create($content, $author_id, $post_id);
        
        // we need send an email to the poster
        $ps = new PostService;
        $post = $ps->getPost($post_id);
        $poster_id = $post->getUserId();
        $user_service = new UserService;
        $poster = $user_service->getUser($poster_id);
        $poster_email = $poster->getEmail();
        $poster_firstname = $poster->getFirstName();
        $server_host = $_SERVER['HTTP_HOST'];
        $subject = $poster_firstname.' commented your post';
        $bodyText = "Hi $poster_firstname,<br><br>$author_firstname commented your post. Please follow the link <a href='http://$server_host/post/item?id=$post_id'>$server_host/post/item?id=$post_id</a> to view the comment.<br><br>feedbakLoop team";
        $to = $poster_email;
        Mailer::sendMail($subject, $bodyText, $to);
        
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(TRUE);
        
        echo json_encode(array('status'=>1, 'firstname'=>$user->getFirstName()));
    }
    
    public function mypostAction() {
        $user = UserService::getLoggedInUser();
        $user_id = $user->getId();
        $ps = new PostService;
        $posts_bymonth = $ps->getMorePostsByUserGroupbyMonth($user_id);
        $this->view->user = $user;
        $this->view->posts_bymonth = $posts_bymonth;
    }
    
    
}
