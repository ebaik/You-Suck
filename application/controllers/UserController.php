<?php

require_once APPLICATION_MODELS . '/UserService.php';
require_once 'BaseController.php';

class UserController extends BaseController
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function registerAction(){

    }

    public function registersubmitAction(){
        // action body
error_log("submit");
        $userservice = new UserService();
        $user = $userservice->createUser($_REQUEST);
        $myAuth = Zend_Auth::getInstance();
            $myAuth->getStorage()->write('id=' . $user->getId() . '&email=' . $user->getFirstname());
            $this->preDispatch();
        return $this->_redirect('/');


    }
    public function indexAction()
    {

        $userservice = new UserService();
        //$this->view->html = $userservice->getUser(1);
        $this->view->html = $userservice->getByEmail('aa');
    }
    
    
	public function loadPostAction()
    {
    	/*
    	$exe = Zend_Registry::get("exe");
        $user_obj = $exe->getGlobalUserObject();

        $sql = " select u.firstname, u.lastname,  p.text,  p.post_time from posts p, user u where p.user_id = u.id and p.text like '%$query%' limit 10  ";
		*/
    }

    
}
