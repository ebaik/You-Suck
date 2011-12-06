<?php

class BaseController extends Zend_Controller_Action{

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
    }

}

