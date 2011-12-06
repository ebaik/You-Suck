<?php
require_once "MyEntityManager.php";

use Doctrine\Common\ClassLoader,
Doctrine\ORM\Configuration,
Doctrine\ORM\EntityManager,
Doctrine\Common\Cache\ArrayCache,
Doctrine\DBAL\Logging\EchoSQLLogger,
Doctrine\ORM\PersistentCollection,
Doctrine\Common\Collections\ArrayCollection,
Doctrine\ORM\Mapping\ClassMetadata;

class ExecuteContext{

    private $config;
    private $dbConfig;
    private $dbEntityManager;
	private $user_obj;
    
    function __construct($setup)
    {
        $dbConnection = $setup["dbConnection"];
        $config = new \Doctrine\ORM\Configuration();
        $config->setProxyDir(APPLICATION_ENTITIES . '/proxies');
        $config->setProxyNamespace('application\common\models\proxies');

        $driverImpl = $config->newDefaultAnnotationDriver(array(APPLICATION_ENTITIES));
        $config->setMetadataDriverImpl($driverImpl);

        $this->config = $config;
        $this->dbConfig = $dbConnection;
    }

    public function getMetaDataEntityManager()
    {
        if (!isset($this->dbEntityManager)) {
            $this->dbEntityManager = MyEntityManager::mycreate($this->dbConfig, $this->config);

            include_once APPLICATION_COMMON . "/CommitListener.php";
            $commitListener = new CommitListener($this, $this->dbEntityManager->getEventManager());
        }
        return $this->dbEntityManager;
    }

    public function persist($entity)
        {
            $em = $this->getMetaDataEntityManager();
            $em->persist($entity);
        }

    public function commit()
    {
        try {
            $em = $this->getMetaDataEntityManager();

            $em->flush();


        } catch (Exception $ex) {
            error_log("Commit Exception:" . $ex->getMessage());
        }
    }

    public function getMetaDataObject($className, $id)
    {
        $em = $this->getMetaDataEntityManager();
        $obj = $em->find($className, $id, 0, 0);
        return $obj;
    }
    
	//temporary function 
	public function setGlobalUserObject($user)
	{
		$this->user_obj = $user;
	}
	
	public function getGlobalUserObject()
	{
        if (!isset($this->user_obj)){
            $this->user_obj = $this->getMetaDataObject('User',1);
        }
		return $this->user_obj;
	}

}
