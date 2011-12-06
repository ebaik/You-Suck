<?php

class Money_Filter_Date implements Zend_Filter_Interface
{
 
    /**
     * string $format Date format to use
     */ 
    public function __construct($format = null)
	{
	}
 
    /**
     * Returns the set date format as string
     * return $string
     */ 
    public function getFormat()
	{
		
	}
 
    /**
     * Sets a new date format to filter to
     * string $format Date format to use
     */ 
    public function setFormat($format)
	{
	}
 
    /**
     * string|Zend_Date $input Date to filter
     */ 
    public function filter($input)
	{
		// return new DateTime("now");
		return $input;
	}
} 
