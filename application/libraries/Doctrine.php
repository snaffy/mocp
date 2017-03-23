<?php
/**
 * Doctrine 2.4 bootstrap
 *
 */

use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\Cache\ArrayCache,
    Doctrine\DBAL\Logging\EchoSQLLogger,
    Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Doctrine {

    public $em;

    public function __construct()
    {
        // Load the database configuration from CodeIgniter
        // cli-config
        require APPPATH.'/config/database.php';
        //app
//        require APPPATH.'config/database.php';

        $connection_options = array(
            'driver'		=> 'pdo_mysql',
            'user'			=> $db['default']['username'],
            'password'		=> $db['default']['password'],
            'host'			=> $db['default']['hostname'],
            'dbname'		=> $db['default']['database'],
            'charset'		=> $db['default']['char_set'],
            'driverOptions'	=> array(
                'charset'	=> $db['default']['char_set'],
            ),
        );
        // With this configuration, your model files need to be in application/models/Entity
        // e.g. Creating a new Entity\User loads the class from application/models/Entity/User.php

        $models_namespace = 'Entity';
        $models_path = APPPATH . 'models';
        $metadata_paths = array(APPPATH . 'models/Entity');
        $isDevMode  = true ;


        // Set up caches
        if(ENVIRONMENT == 'development')  // set environment in index.php
            // set up simple array caching for development mode
            $cache = new Doctrine\Common\Cache\ArrayCache();
        else
            // set up caching with APC for production mode
            $cache = new \Doctrine\Common\Cache\ApcCache;

        $config = Setup::createConfiguration($isDevMode);

        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        // set up annotation driver
        // If you want to use a different metadata driver, change createAnnotationMetadataConfiguration
        // to createXMLMetadataConfiguration or createYAMLMetadataConfiguration.
        $driver = new AnnotationDriver(new AnnotationReader(), $metadata_paths);
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);

        // Proxy configuration
        $proxies_dir = APPPATH . 'models/Proxies';
        $config->setProxyDir( $proxies_dir);
        $config->setProxyNamespace('Proxies');

        // Set up logger
//        $logger = new EchoSQLLogger;
//        $config->setSQLLogger($logger);

        //$config = Setup::createAnnotationMetadataConfiguration($metadata_paths, $dev_mode, $proxies_dir);
        $this->em = EntityManager::create($connection_options, $config);
        //var_dump($this-em);
        $loader = new ClassLoader($models_namespace, $models_path);
        $loader->register();
    }
}