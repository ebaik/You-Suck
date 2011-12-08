<?php
use Doctrine\Common\ClassLoader,
Doctrine\ORM\Configuration,
Doctrine\ORM\EntityManager,
Doctrine\Common\Cache\ArrayCache,
Doctrine\DBAL\Logging\EchoSQLLogger;

include_once realpath(__DIR__ . '/configs/config.php');

require_once(realpath(__DIR__ . '/../lib') . '/doctrine/Doctrine/Common/ClassLoader.php');
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\ORM', realpath(__DIR__ . '/../lib/doctrine'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\DBAL', realpath(__DIR__ . '/../lib/doctrine'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Doctrine\Common', realpath(__DIR__ . '/../lib/doctrine'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', realpath(__DIR__ . '/../lib/doctrine'));
$classLoader->register();
$classLoader = new \Doctrine\Common\ClassLoader('application\common\models', realpath(__DIR__ . '/common/models'));
$classLoader->register();


//no way to have your proxies generated in different directory per ZF module it seems so we use a global one
// $proxiesClassLoader = new ClassLoader('application\common\models\proxies', realpath(__DIR__ . '/common/models/proxies'));
// $proxiesClassLoader->register();
