<?php

namespace App\Domain\Model\User;

use DateTime;
use DateTimeImmutable;

/**
 * Represents a User entity in the domain.
 * 
 * This class encapsulates user-related data and ensures immutability
 * for core attributes such as ID, name, email, password, and creation date.
 * It also exposes primitive values for ORM mapping.
 */
class User
{
    /**
     * @var UserId The unique identifier for the user.
     */
    private UserId $id;

    /**
     * @var Name The name of the user.
     */
    private Name $name;

    /**
     * @var Email The email address of the user.
     */
    private Email $email;

    /**
     * @var Password The hashed password of the user.
     */
    private Password $password;

    /**
     * @var DateTimeImmutable The date and time when the user was created.
     */
    private DateTimeImmutable $createdAt;

    /**
     * User constructor.
     * 
     * @param UserId $id The unique identifier for the user.
     * @param Name $name The name of the user.
     * @param Email $email The email address of the user.
     * @param Password $password The hashed password of the user.
     */
    public function __construct(
        UserId $id,
        Name $name,
        Email $email,
        Password $password
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * Factory method to create a new user instance.
     * 
     * This method generates a unique ID for the user and creates
     * instances of Name, Email, and Password based on the provided inputs.
     * 
     * @param string $name The name of the user.
     * @param string $email The email address of the user.
     * @param string $password The plain-text password of the user.
     * 
     * @return self A new User instance.
     */
    public static function create(
        string $name,
        string $email,
        string $password
    ): self {
        return new self(
            UserId::generate(),
            new Name($name),
            new Email($email),
            new Password($password)
        );
    }

    /**
     * Gets the user's unique identifier.
     * 
     * @return UserId The user's ID.
     */
    public function id(): UserId
    {
        return $this->id;
    }

    /**
     * Gets the user's name.
     * 
     * @return Name The user's name.
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * Gets the user's email address.
     * 
     * @return Email The user's email.
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * Gets the user's hashed password.
     * 
     * @return Password The user's hashed password.
     */
    public function password(): Password
    {
        return $this->password;
    }

    /**
     * Gets the date and time when the user was created.
     * 
     * @return DateTimeImmutable The creation date and time.
     */
    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
