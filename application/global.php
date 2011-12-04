<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

date_default_timezone_set('America/Los_Angeles');

/*
 * Setup libraries & autoloaders 
 */

define("ROOT_DIR", __DIR__ . "/../");

set_include_path(__DIR__ . '/../library/zendframework'
                 . PATH_SEPARATOR . __DIR__ . '/../lib/doctrine'
                 . PATH_SEPARATOR . __DIR__ . '/../library'
                 . PATH_SEPARATOR . __DIR__ . '/common/models'
                 . PATH_SEPARATOR . __DIR__ . '/common'
                 . PATH_SEPARATOR . __DIR__ . '/'
                 . PATH_SEPARATOR . get_include_path());


require_once 'Zend/Loader/Autoloader.php';

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->suppressNotFoundWarnings(false);
$autoloader->setFallbackAutoloader(true);
$autoloader->pushAutoloader('smartyAutoload', 'Smarty');

$autoloader->registerNamespace('Zend_Loader');
$autoloader->registerNamespace('Doctrine');
$autoloader->registerNamespace('Smarty');


//
// Configure Doctrine
//

Zend_Registry::set('doctrine_config', array(
                                           'data_fixtures_path' => dirname(__FILE__) . '/doctrine/data/fixtures',
                                           'models_path' => dirname(__FILE__) . '/common/models',
                                           'migrations_path' => dirname(__FILE__) . '/doctrine/migrations',
                                           'sql_path' => dirname(__FILE__) . '/doctrine/data/sql',
                                           'yaml_schema_path' => dirname(__FILE__) . '/doctrine/schema'));

