<?php

namespace App\Application\UseCase\RegisterUser;

use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\Model\User\Email;
use App\Domain\Model\User\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\Event\UserRegisteredEvent;
use App\Infrastructure\EventDispatcher\SimpleEventDispatcher;

/**
 * Use case for registering a new user.
 * 
 * This class handles the business logic for registering a user, including
 * validating the email, creating the user, saving it, and dispatching the domain event.
 */
final class RegisterUserUseCase
{
    /**
     * @var UserRepositoryInterface The repository for managing user persistence.
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var SimpleEventDispatcher The event dispatcher for handling domain events.
     */
    private SimpleEventDispatcher $eventDispatcher;

    /**
     * RegisterUserUseCase constructor.
     * 
     * @param UserRepositoryInterface $userRepository The user repository.
     * @param SimpleEventDispatcher $eventDispatcher The event dispatcher.
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        SimpleEventDispatcher $eventDispatcher
    ) {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Executes the use case to register a new user.
     * 
     * @param RegisterUserRequest $request The request containing user registration data.
     * 
     * @return UserResponseDTO The response DTO containing the registered user's data.
     * 
     * @throws UserAlreadyExistsException If a user with the provided email already exists.
     */
    public function execute(RegisterUserRequest $request): UserResponseDTO
    {
        // Validate the email format and create an Email value object
        $email = new Email($request->email());

        // Check if a user with this email already exists
        $existingUser = $this->userRepository->findByEmail($email);
        if ($existingUser !== null) {
            throw new UserAlreadyExistsException('User with this email already exists');
        }

        // Create and save the user
        $user = User::create(
            $request->name(),
            $request->email(),
            $request->password()
        );

        $this->userRepository->save($user);

        // Dispatch domain event
        $event = new UserRegisteredEvent($user);
        $this->eventDispatcher->dispatch($event);

        // Return a response DTO with the user's data
        return new UserResponseDTO($user);
    }
}
