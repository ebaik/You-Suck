<?php

use Doctrine\Common\EventManager,
    Doctrine\DBAL\Connection,
    Doctrine\DBAL\LockMode,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\Mapping\ClassMetadata,
    Doctrine\ORM\Mapping\ClassMetadataFactory,
    Doctrine\ORM\Query\ResultSetMapping,
    Doctrine\ORM\Proxy\ProxyFactory;


class MyEntityManager extends EntityManager
{

    protected function __construct(Connection $conn, Configuration $config, EventManager $eventManager, $dbnum)
    {
        EntityManager::__construct($conn, $config, $eventManager);
        
    }
    
    /**
     * Factory method to create EntityManager instances.
     *
     * @param mixed $conn An array with the connection parameters or an existing
     *      Connection instance.
     * @param Configuration $config The Configuration instance to use.
     * @param EventManager $eventManager The EventManager instance to use.
     * @return EntityManager The created EntityManager.
     */
    public static function mycreate($conn, Configuration $config, $dbnum =0, EventManager $eventManager = null)
    {
        if (!$config->getMetadataDriverImpl()) {
            throw ORMException::missingMappingDriverImpl();
        }

        if (is_array($conn)) {
            $conn = \Doctrine\DBAL\DriverManager::getConnection($conn, $config, ($eventManager ?: new EventManager()));
        } else if ($conn instanceof Connection) {
            if ($eventManager !== null && $conn->getEventManager() !== $eventManager) {
                 throw ORMException::mismatchedEventManager();
            }
        } else {
            throw new \InvalidArgumentException("Invalid argument: " . $conn);
        }

        return new MyEntityManager($conn, $config, $conn->getEventManager(), $dbnum);
    }

   
}
