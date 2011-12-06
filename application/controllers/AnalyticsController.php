<?php

require_once APPLICATION_MODELS . '/UserService.php';
require_once APPLICATION_MODELS . '/PostService.php';
require_once 'BaseController.php';

class AnalyticsController extends BaseController
{

    public function indexAction(){

    }
    
    public function companyAction(){
        $serv = new PostService();
        $this->view->posts = $serv->getPostByCompany($_REQUEST['company']);
    }
}
