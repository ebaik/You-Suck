<?php

require_once APPLICATION_MODELS . '/UserService.php';
require_once 'BaseController.php';
require_once APPLICATION_COMMON.'/Mailer.php';

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

        $userservice = new UserService();
        $user = $userservice->createUser($_REQUEST);
        $myAuth = Zend_Auth::getInstance();
        $myAuth->getStorage()->write('id=' . $user->getId() . '&email=' . $user->getFirstname());
        $this->preDispatch();
        return $this->_redirect('/');


    }
    
    public function createAction() {
        $userservice = new UserService();
        $user = $userservice->createUser($_REQUEST);
        $myAuth = Zend_Auth::getInstance();
        $myAuth->getStorage()->write('id=' . $user->getId() . '&email=' . $user->getFirstname());
        
        // send an email to the registered user
        $subject = "Thank you for using feedbakLOOP. Don't let your voice go unheard";
        $firstname = $user->getFirstname();
        $bodyText = "Hi $firstname, <br><br> Thank you for using feedbakLoop, letting your voice go heard. Don't suffer in silence. Tell the story of how you were wronged to the world. Obtain critical mass by submitting your complaint. Hold companies responsible so it doesn't happen again.<br><br>feedbakLOOP team";
        $to = $user->getEmail();
        Mailer::sendMail($subject, $bodyText, $to);
        
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(TRUE);
        echo 1;
    }
    
    public function emailregisteredAction() {
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(TRUE);
        $email = trim($_REQUEST['email']);
        if(!empty($email)) {
            $user_service = new UserService();
            if($user_service->getByEmail($email)) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 1;
        }
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
