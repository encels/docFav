<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\RegisterUser\RegisterUserRequest;
use App\Application\UseCase\RegisterUser\RegisterUserUseCase;
use App\Domain\Exception\InvalidEmailException;
use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\Exception\WeakPasswordException;

/**
 * Controller responsible for handling user registration requests.
 */
final class RegisterUserController
{
    /**
     * Use case for registering a new user.
     *
     * @var RegisterUserUseCase
     */
    private RegisterUserUseCase $registerUserUseCase;

    /**
     * Generic error message for unexpected exceptions.
     */
    private const GENERIC_ERROR_MESSAGE = 'An unexpected error occurred';

    /**
     * Constructor.
     *
     * @param RegisterUserUseCase $registerUserUseCase The use case for registering a user.
     */
    public function __construct(RegisterUserUseCase $registerUserUseCase)
    {
        $this->registerUserUseCase = $registerUserUseCase;
    }

    /**
     * Handles the user registration request.
     *
     * @param array $requestData The request data containing 'name', 'email', and 'password'.
     *
     * @return array A JSON-formatted response with the status of the operation.
     *
     * @throws \InvalidArgumentException If required fields are missing or invalid.
     */
    public function __invoke(array $requestData): array
    {
        // Validate input data
        if (empty($requestData['name']) || empty($requestData['email']) || empty($requestData['password'])) {
            throw new \InvalidArgumentException('Missing required fields: name, email, or password');
        }

        try {
            // Create the registration request
            $request = new RegisterUserRequest(
                $requestData['name'],
                $requestData['email'],
                $requestData['password']
            );

            // Execute the use case
            $response = $this->registerUserUseCase->execute($request);

            // Return a successful response
            return [
                'status' => 'success',
                'data' => $response->toArray(),
            ];
        } catch (InvalidEmailException | WeakPasswordException | UserAlreadyExistsException | \Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'exception_type' => basename(str_replace('\\', '/', get_class($e))),
            ];
        }
    }
}
