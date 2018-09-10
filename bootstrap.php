<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once './vendor/autoload.php';

$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), true);

$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);

$entityManager = EntityManager::create($conn, $config);