<?php

require_once __DIR__ . '/doctrineSetup.php';


class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initDoctrine()
    {
        require_once(__DIR__ . '/configs/config.php');
        include_once realpath(__DIR__ . "/common/ExecuteContext.php");
        global $setupContext;

        $exe = new ExecuteContext($setupContext);

        Zend_Registry::set('exe', $exe);
        return $exe;
    }
    
     protected function _initViewHelpers() {
     	$this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $view->user = $user = Zend_Auth::getInstance()->getStorage()->read();
     }

}

