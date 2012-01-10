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
            
            return $this->_redirect('/');
        } else {
            $this->view->html = 'failed';
            return $this->_redirect('/login');
        }

    }

    // auth can be done by the following two way:
    // 1. site login -- 
    // input: username, password
    // ops: check the user table, get the user info, store it in the session and cookie
    // 2. fb connect login
    // input: access_token
    // ops: get the acces token and get the user info from graph api, store it in the db, session and cookie
    // access_token: "AAADsdNZCvss4BAN2IrdUXZAFWkDIBZCU1J7UMmA11aTefmM0vXRTjVvlWKPhLhiq77BhMr4qGggiFjfR8JZBcVtDm808ZCZBobrAZBMZCRmb0xdZAuJYHlaCG" 
    // base_domain: "yousuckapp.com"
    // expires: 1323676800
    // secret: "zrFiDL4f_sATwQSGxBWZtA__"
    // session_key: "2.AQDw0nQ93Gee_gEU.3600.1323676800.1-1693922445"
    // sig: "826c46f50e617736468ca7d6d6d46838"
    // uid: "1693922445"
    public function authAction()
    {
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(TRUE);
        $userservice = new UserService();
        if(isset($_REQUEST['username']) && $_REQUEST['password']) {
            // regular login
            $user = $userservice->checklogin($_REQUEST['username'], $_REQUEST['password']);
            if (isset($user) && !empty($user)) {
                $myAuth = Zend_Auth::getInstance();
                $myAuth->getStorage()->write('id=' . $user->getId() . '&email=' . $user->getFirstname());
                echo 1;
                setcookie('userid', $user->getId(), 0, '/', 'feedbakloop.com');
                setcookie('firstname', $user->getFirstname(), 0, '/', 'feedbakloop.com');
                return;
            } else {
                echo 0;
                return;
            }
        } else if(isset($_REQUEST['access_token'])) {
            // fb login
            $graph_url = "https://graph.facebook.com/me?access_token=".$_REQUEST['access_token'];
            $fbuser = json_decode(file_get_contents($graph_url));
            $user = $userservice->getByfbuid($fbuser->id);
            if (!isset($user) || empty($user) ){
                $user = $userservice->createUser(get_object_vars($fbuser));
            }
            echo 1;
            $myAuth = Zend_Auth::getInstance();
            $myAuth->getStorage()->write('id=' . $user->getId() . '&email=' . $user->getFirstname());
            setcookie('userid', $user->getId(), 0, '/', 'feedbakloop.com');
            setcookie('firstname', $user->getFirstname(), 0, '/', 'feedbakloop.com');
            return;
        }
        echo 0;
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
            
            return $this->_redirect('/');
        }
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        return $this->_redirect('/');
    }

}

