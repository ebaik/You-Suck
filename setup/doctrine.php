<?php
// Variable $helperSet is defined inside cli-config.php
define("ADMINPATH",  __DIR__ . "/../application");
define("APPLICATION_COMMON", __DIR__ . "/../application/common");
defined('APPLICATION_PATH') || define('APPLICATION_PATH', __DIR__ . '/../application');
defined('LIBRARY_PATH') || define('LIBRARY_PATH', __DIR__ . '/../library');
defined('APPLICATION_ENTITIES') || define('APPLICATION_ENTITIES', __DIR__ . '/../application/common/models');

require ADMINPATH . '/doctrineSetup.php';

$metadataConnection = $setupContext['dbConnection'];
mapDatabase($metadataConnection, APPLICATION_ENTITIES);


function mapDatabase($connectionOptions, $entitydir)
{
	$config = new \Doctrine\ORM\Configuration();
	$cache = new \Doctrine\Common\Cache\ArrayCache();

	$driverImpl = $config->newDefaultAnnotationDriver(array($entitydir));
	$config->setProxyDir(APPLICATION_ENTITIES . "/proxies");
	$config->setProxyNamespace('application\common\models\proxies');
	$config->setMetadataDriverImpl($driverImpl);
	$config->setMetadataCacheImpl($cache);
	$config->setQueryCacheImpl($cache);

	// Proxy configuration
	$config->setAutoGenerateProxyClasses(false);
	$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

	$helpers = array(
		'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
		'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
	);

	$cli = new \Symfony\Component\Console\Application('Doctrine Command Line Interface', Doctrine\Common\Version::VERSION);
	$cli->setAutoExit(false);
	$cli->setCatchExceptions(true);
	$helperSet = $cli->getHelperSet();
	foreach ($helpers as $name => $helper)
	{
		$helperSet->set($helper, $name);
	}
	$cli->addCommands(array(
    	// DBAL Commands
	    new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),
		new \Doctrine\DBAL\Tools\Console\Command\ImportCommand(),

		// ORM Commands
		new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
		new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
		new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
		new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
		new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
		new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
		new \Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
		new \Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
		new \Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
		new \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
		new \Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
		new \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand(),
		new \Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
		new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),
	));
	$cli->run();
}

