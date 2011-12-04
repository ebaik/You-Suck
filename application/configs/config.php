<?php
global $setupContext;
$setupContext = array(
	'doctrine_cachetype' => 'ArrayCache',
	'dbConnection' => array(
		  'driver' => 'pdo_mysql',
		  'dbname' => 'ys',
		  'host' => 'localhost',
		  'user' => 'root',
		  'password' => 'root'	)

);
