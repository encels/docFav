<?php

namespace App\Domain\Model\User;

use App\Domain\Exception\InvalidEmailException;

/**
 * Represents a user's email address.
 * 
 * This class ensures that the email address is valid and immutable.
 * It provides utility methods to validate, retrieve, and compare email values.
 */
final class Email
{
    /**
     * @var string The email address value.
     */
    private string $value;

    /**
     * Email constructor.
     * 
     * @param string $email The email address value.
     * 
     * @throws InvalidEmailException If the provided email address is invalid.
     */
    public function __construct(string $email)
    {
        $this->validate($email);
        $this->value = $email;
    }

    /**
     * Validates the provided email address.
     * 
     * Ensures that the email address follows the correct format.
     * 
     * @param string $email The email address to validate.
     * 
     * @throws InvalidEmailException If the email address format is invalid.
     */
    private function validate(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException('Invalid email format.');
        }
    }

    /**
     * Returns the value of the email address.
     * 
     * @return string The email address value.
     */
    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * Compares this Email with another Email for equality.
     * 
     * @param Email $anotherEmail The other Email object to compare with.
     * 
     * @return bool True if both Email objects have the same value, false otherwise.
     */
    public function equals(Email $anotherEmail): bool
    {
        return strtolower($this->value) === strtolower($anotherEmail->value);
    }
}
