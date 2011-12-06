<?php

class Money_Decorator_Chooser extends Zend_Form_Decorator_Abstract
{
    protected $_placement = 'PREPEND';

    public function render($content)
    {
		return $content . "<submit class='notcss_chooser'>Template Chooser</a>";
    }
}

