<?php

use App\Application\EventHandler\UserRegisteredEventHandler;
use App\Application\UseCase\RegisterUser\RegisterUserUseCase;
use App\Domain\Event\UserRegisteredEvent;
use App\Infrastructure\Controller\RegisterUserController;
use App\Infrastructure\EventDispatcher\SimpleEventDispatcher;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

require_once __DIR__ . '/../vendor/autoload.php';

// Get entity manager
$entityManager = require_once __DIR__ . '/../config/bootstrap.php';

// Set up event dispatcher
$eventDispatcher = new SimpleEventDispatcher();
$eventHandler = new UserRegisteredEventHandler();
$eventDispatcher->addListener(
    UserRegisteredEvent::class,
    [$eventHandler, 'handle']
);

// Set up repository
$userRepository = new DoctrineUserRepository($entityManager);

// Set up use case
$registerUserUseCase = new RegisterUserUseCase($userRepository, $eventDispatcher);

// Set up controller
$controller = new RegisterUserController($registerUserUseCase);

// Get request data (in a real app, this would come from $_POST or a request object)
$requestData = json_decode(file_get_contents('php://input'), true) ?? [];

// Process request
$response = $controller($requestData);

// Send response
header('Content-Type: application/json');
echo json_encode($response);
