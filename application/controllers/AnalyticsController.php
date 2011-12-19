<?php

require_once APPLICATION_MODELS . '/UserService.php';
require_once APPLICATION_MODELS . '/PostService.php';
require_once APPLICATION_MODELS . '/CompanyService.php';
require_once 'BaseController.php';


// google chart js api
// http://code.google.com/apis/chart/interactive/docs/gallery/linechart.html

class AnalyticsController extends BaseController
{

    public function indexAction(){

    }
    
    public function companyAction(){
        $serv = new PostService();
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(TRUE);
        echo $serv->getPostByCompany($_REQUEST['company']);
    }
    
    public function showAction() {
        
    }
    
    public function getdataAction() {
        $company = $this->_getParam('company');
        $scale = $this->_getParam('scale');
        $exe = Zend_Registry::get("exe");
        $cs = new CompanyService();
        $result = $cs->getCompanyAnalytics($company, $scale);
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(TRUE);
        echo json_encode($result);
    }
    
}
