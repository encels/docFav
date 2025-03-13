<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;

require_once __DIR__ . '/../vendor/autoload.php';

$isDevMode = true;

$dbParams = [
    'driver'   => 'pdo_mysql',
    'user'     => 'user', 
    'password' => 'password',  
    'dbname'   => 'app_db',
    'host'     => 'mysql',
    'charset'  => 'utf8mb4'
];

$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

return $entityManager;
