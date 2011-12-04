<?php

require_once APPLICATION_ENTITIES . '/User.php';
require_once APPLICATION_MODELS . '/UserService.php';


class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $userservice = new UserService();
        $userservice->createUser();

        //$this->view->html = $userservice->getUser(1);
        $this->view->html = $userservice->getByEmail('aa');
        
    }


}

