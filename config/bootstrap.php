<?php

use App\Infrastructure\Persistence\Doctrine\Type\EmailType;
use App\Infrastructure\Persistence\Doctrine\Type\NameType;
use App\Infrastructure\Persistence\Doctrine\Type\PasswordType;
use App\Infrastructure\Persistence\Doctrine\Type\UserIdType;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/../vendor/autoload.php';

if (!Type::hasType(UserIdType::NAME)) {
    Type::addType(UserIdType::NAME, UserIdType::class);
}

if (!Type::hasType(NameType::NAME)) {
    Type::addType(NameType::NAME, NameType::class);
}

if (!Type::hasType(EmailType::NAME)) {
    Type::addType(EmailType::NAME, EmailType::class);
}

if (!Type::hasType(PasswordType::NAME)) {
    Type::addType(PasswordType::NAME, PasswordType::class);
}


$paths = [__DIR__ . '/../src/Infrastructure/Persistence/Doctrine/Mapping'];
$isDevMode = true;

$dbParams = [
    'driver'   => 'pdo_mysql',
    'user'     => 'user',
    'password' => 'password',  
    'dbname'   => 'app_db',
    'host'     => 'mysql',
    'charset'  => 'utf8mb4'
];

$config = ORMSetup::createXMLMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

$platform = $connection->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('user_id', UserIdType::NAME);
$platform->registerDoctrineTypeMapping('name', NameType::NAME);
$platform->registerDoctrineTypeMapping('email', EmailType::NAME);
$platform->registerDoctrineTypeMapping('password', PasswordType::NAME);

return $entityManager;
