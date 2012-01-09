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
        $company_name = trim($this->_getParam('company'));
        $this->view->company_name = $company_name;
    }
    
    public function getdataAction() {
        $company = $this->_getParam('company');
        $scale = $this->_getParam('scale');
        $exe = Zend_Registry::get("exe");
        $cs = new CompanyService();
        $result = $cs->getCompanyAnalytics($company, $scale);
        $size = count($result);
        date_default_timezone_set('UTC');
        $curr_month = date('F', time());
        $prev_month = date('F', strtotime('-1 month'));
        $prev2_month = date('F', strtotime('-2 month'));
        $final_result = array(
            array($prev2_month, 0),
            array($prev_month, 0),
            array($curr_month, 0)
        );
        if($size<3) {
            foreach($result as $item) {
                foreach($final_result as $i=>$final_item) {
                    if(in_array($item[0], $final_item, true)) {
                        $final_result[$i][1] = $item[1];
                    }
                }
            }
        }
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(TRUE);
        echo json_encode($final_result);
    }
    
}
