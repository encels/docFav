<?php

namespace App\Domain\Model\User;

use App\Domain\Exception\WeakPasswordException;

/**
 * Represents a user's password.
 * 
 * This class ensures that the password is strong and securely hashed.
 * It provides methods to validate, hash, and verify passwords.
 */
final class Password
{
    /**
     * @var string The hashed password value.
     */
    private string $hashedValue;

    /**
     * Password constructor.
     * 
     * @param string $plainPassword The plain-text password.
     * 
     * @throws WeakPasswordException If the provided password does not meet the required strength criteria.
     */
    public function __construct(string $plainPassword)
    {
        $this->validate($plainPassword);
        $this->hashedValue = password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    /**
     * Validates the strength of the provided password.
     * 
     * Ensures that the password meets the following criteria:
     * - At least 8 characters long.
     * - Contains at least one uppercase letter.
     * - Contains at least one number.
     * - Contains at least one special character.
     * 
     * @param string $password The plain-text password to validate.
     * 
     * @throws WeakPasswordException If the password does not meet the strength requirements.
     */
    private function validate(string $password): void
    {
        if (mb_strlen($password) < 8) {
            throw new WeakPasswordException('Password must be at least 8 characters long.');
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new WeakPasswordException('Password must contain at least one uppercase letter.');
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new WeakPasswordException('Password must contain at least one number.');
        }

        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            throw new WeakPasswordException('Password must contain at least one special character.');
        }
    }

    /**
     * Returns the hashed value of the password.
     * 
     * @return string The hashed password value.
     */
    public function value(): string
    {
        return $this->hashedValue;
    }

    public function __toString(): string
    {
        return $this->value(); 
    }

    /**
     * Verifies if the provided plain-text password matches the hashed password.
     * 
     * Uses PHP's `password_verify` function for secure verification.
     * 
     * @param string $plainPassword The plain-text password to verify.
     * 
     * @return bool True if the password matches, false otherwise.
     */
    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedValue);
    }
}
