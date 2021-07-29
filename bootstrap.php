<?php

require './vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Resources Slim Container
 */
$container = new \Slim\Container();

$isDevMode = true;

/**
 * Entity Directory and Doctrine
 */
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Models/Entity"), $isDevMode);

/**
 * Settings arrat database connection
 */
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);

/**
 * Entity Manager instance
 */
$entityManager = EntityManager::create($conn, $config);


/**
 * Entity manager inside container
 */
$container['em'] = $entityManager;

$app = new \Slim\App($container);