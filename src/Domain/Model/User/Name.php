<?php

namespace App\Domain\Model\User;

use InvalidArgumentException;

/**
 * Represents a user's name.
 * 
 * This class ensures that the name is valid and immutable. It enforces rules
 * such as minimum length and allowed characters.
 */
final class Name
{
    /**
     * @var string The name value.
     */
    private string $value;

    /**
     * The minimum length required for a valid name.
     */
    private const MIN_LENGTH = 2;

    /**
     * Name constructor.
     * 
     * @param string $name The name value.
     * 
     * @throws InvalidArgumentException If the provided name is invalid.
     */
    public function __construct(string $name)
    {
        $this->validate($name);
        $this->value = $name;
    }

    /**
     * Validates the provided name.
     * 
     * Ensures that the name is not empty, meets the minimum length requirement,
     * and only contains letters and spaces.
     * 
     * @param string $name The name value to validate.
     * 
     * @throws InvalidArgumentException If the name is empty, too short, or contains invalid characters.
     */
    private function validate(string $name): void
    {
        if (empty(trim($name))) {
            throw new InvalidArgumentException('Name cannot be empty.');
        }

        if (mb_strlen($name) < self::MIN_LENGTH) {
            throw new InvalidArgumentException(
                sprintf('Name must be at least %d characters long.', self::MIN_LENGTH)
            );
        }

        if (!preg_match('/^[a-zA-Z\s]+$/u', $name)) {
            throw new InvalidArgumentException('Name can only contain letters and spaces.');
        }
    }

    /**
     * Returns the value of the name.
     * 
     * @return string The name value.
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
     * Compares this Name with another Name for equality.
     * 
     * @param Name $anotherName The other Name object to compare with.
     * 
     * @return bool True if both Name objects have the same value, false otherwise.
     */
    public function equals(Name $anotherName): bool
    {
        return $this->value === $anotherName->value;
    }
}
