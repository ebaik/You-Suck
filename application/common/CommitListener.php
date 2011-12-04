<?php

require_once "Zend/Auth.php";

class CommitListener
{
    private $exe;

    public function __construct($exe, $evm)
    {
        $this->exe = $exe;
        $evm->addEventListener("onFlush", $this);
    }

    public function onFlush($eventArgs)
    {
        
    }
}
