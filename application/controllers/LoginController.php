<?php

require_once APPLICATION_MODELS . '/UserService.php';
require_once 'BaseController.php';


class LoginController extends BaseController
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        
    }
    
    public function defaultAction() 
    {
        
    }

    public function loginAction()
    {
        $userservice = new UserService();
        $user = $userservice->checklogin($_REQUEST['username'], $_REQUEST['password']);
        if (isset($user) && !empty($user)) {
            $this->view->html = 'sucess';
            $myAuth = Zend_Auth::getInstance();
            $myAuth->getStorage()->write('id=' . $user->getId() . '&email=' . $user->getFirstname());
            $this->preDispatch();
            
            return $this->_redirect('/');
        } else {
            $this->view->html = 'failed';
            return $this->_redirect('/login');
        }

    }

    public function authAction()
    {
        $userservice = new UserService();
        $user = $userservice->checklogin($_REQUEST['username'], $_REQUEST['password']);
        if (isset($user) && !empty($user)) {
            $this->view->html = 'sucess';
            $myAuth = Zend_Auth::getInstance();
            $myAuth->getStorage()->write('id=' . $user->getId() . '&email=' . $user->getFirstname());
            $this->preDispatch();
            $this->view->html = 1;
        } else {
            $this->view->html = 0;
        }
    }

    public function facebookAction()
    {
        if (array_key_exists('code', $_REQUEST)) {
            //success

            $token_url = "https://graph.facebook.com/oauth/access_token?"
                         . "client_id=249701408427601&redirect_uri=http://www.yousuckapp.com/login/facebook&client_secret=fb947ae172e6e2bbc41c84f5fa129d70&code={$_REQUEST['code']}";

            $response = @file_get_contents($token_url);
            $params = null;
            parse_str($response, $params);

            $graph_url = "https://graph.facebook.com/me?access_token="
                         . $params['access_token'];

            $fbuser = json_decode(file_get_contents($graph_url));
            $userserv = new UserService();
            //check if user exists
            $user = $userserv->getByfbuid($fbuser->id);
            if (!isset($user) || empty($user) ){
                $user = $userserv->createUser(get_object_vars($fbuser));
            }
            $this->view->html = 'sucess';
            $myAuth = Zend_Auth::getInstance();
            $myAuth->getStorage()->write('id=' . $user->getId() . '&email=' . $user->getFirstname());
            $this->preDispatch();
            return $this->_redirect('/');
        }
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        return $this->_redirect('/');
    }

}

