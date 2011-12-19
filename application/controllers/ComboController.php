<?php
require_once 'BaseController.php';

class ComboController extends BaseController 
{
    
    public function init() 
    {
        
    }

    
    // this is a combo loader which combines multiple js files and send them back
    // one time
    public function indexAction() 
    {
        $comboJS = '';
        $cwd = getcwd();
        // url: http://host/combo?f=file1;file2;file3
        $files = explode(';', $_REQUEST['f']); 
        foreach($files as $file)
        {
            $comboJS .= file_get_contents($file);
        }
        $this->_helper->layout->disableLayout();
	$this->_helper->viewRenderer->setNoRender(TRUE);
        echo $comboJS;
    }
    
}

