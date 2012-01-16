<?php
require_once APPLICATION_MODELS . '/UserService.php';
require_once APPLICATION_MODELS . '/SessionService.php';
require_once APPLICATION_MODELS . '/ResponseService.php';

class BaseController extends Zend_Controller_Action{

    protected $session = null;
    
    public function init(){
        //$this->layout = $this->_helper->layout();
        //$this->view->layout()->disableLayout();
    }
    public function preDispatch()
    {
        $user = null;
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $user = UserService::getLoggedInUser();
        }
        if (isset($user)) {
            $this->view->user = $user;
            Zend_Registry::get("exe")->setGlobalUserObject($user);
        } else {
        }
        if(isset($_REQUEST['session_id'])) {
            $session_id = $_REQUEST['session_id'];
            $this->session = new SessionService($session_id);
            $session_id = $this->session->getId();
            if(empty($session_id)) {
                // create a new session
                $this->session = SessionService::create();
                ResponseService::getInstance()->set_header('session_id', $this->session->getId());
            }
        }
    }
    
    protected function is_login() {
        $user_id = $this->session->get('user_id');
        if(empty($user_id)) {
            return false;
        } else {
            return true;
        }
    } 

}

