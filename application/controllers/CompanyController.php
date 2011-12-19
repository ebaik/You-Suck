<?php
require_once 'BaseController.php';
require_once APPLICATION_MODELS . '/CompanyService.php';

class CompanyController extends BaseController 
{
    
    public function init() 
    {
        
    }

    
    // get the top 10 companies from the db table companies based on the query string
    public function suggestAction() 
    {
        $q = $this->_getParam('q');
        
        $exe = Zend_Registry::get("exe");
        $cs = new CompanyService();
        $company_names = $cs->getCompanyByString($q);
        $companies = "";
        foreach($company_names as $company) 
        {
            $companies .= "\n".$company;
        }
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(TRUE);
        echo $companies;
    }
    
}

