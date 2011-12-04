<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $userservice = new UserService();
        $userservice->createUser();

        //$this->view->html = $userservice->getUser(1);
        $this->view->html = $userservice->getByEmail('aa');
    }
    
    public function postAction()
    {
    
    }

    public function loadPostAction()
    {
    	
    }

    
}