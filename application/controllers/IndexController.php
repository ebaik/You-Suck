<?php

require_once 'BaseController.php';

require_once APPLICATION_ENTITIES . '/Posts.php';
require_once APPLICATION_ENTITIES . '/User.php';
require_once APPLICATION_ENTITIES . '/Companies.php';
require_once APPLICATION_MODELS . '/UserService.php';
require_once APPLICATION_MODELS . '/CompanyService.php';
require_once APPLICATION_MODELS . '/PostService.php';

class IndexController extends BaseController
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    	try{
                $ps = new PostService();
                $posts = $ps->getMorePost();
                $this->view->posts = $posts;
	       
    	}
    	catch (Exception $ex) {
            error_log("Index exception:" . $ex->getMessage());
            return false;
        }
    }
}

