<?php

namespace App\Application\UseCase\RegisterUser;

/**
 * Data Transfer Object (DTO) for registering a new user.
 * 
 * This class encapsulates the data required to register a user, ensuring
 * immutability and type safety for the input values.
 */
final class RegisterUserRequest
{
    /**
     * @var string The name of the user.
     */
    private string $name;

    /**
     * @var string The email of the user.
     */
    private string $email;

    /**
     * @var string The password of the user.
     */
    private string $password;

    /**
     * RegisterUserRequest constructor.
     * 
     * @param string $name The name of the user.
     * @param string $email The email of the user.
     * @param string $password The password of the user.
     */
    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Gets the user's name.
     * 
     * @return string The name of the user.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Gets the user's email.
     * 
     * @return string The email of the user.
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * Gets the user's password.
     * 
     * @return string The password of the user.
     */
    public function password(): string
    {
        return $this->password;
    }
}
