<?php
require_once 'BaseController.php';

class CompanyController extends BaseController 
{
    
    public function init() 
    {
        
    }

    
    // get the top 10 companies from the db table companies based on the query string
    public function suggestAction() 
    {
        $query = $_REQUEST['q'];
        $sql = "select company_name from companies where company_name like '%$query%'";
        
        $exe = Zend_Registry::get("exe");
	$em = $exe->getMetaDataEntityManager();
        
        $this->view->companies = 'citibank boa delta';
    }
    
}

