<?php

namespace App\Domain\Model\User;

use InvalidArgumentException;

/**
 * Represents a unique identifier for a User entity.
 * 
 * This class ensures that the identifier is valid and immutable. It also provides
 * utility methods to generate, compare, and retrieve the value of the identifier.
 */
final class UserId
{
    /**
     * @var string The unique identifier value.
     */
    private string $value;

    /**
     * UserId constructor.
     * 
     * @param string $value The unique identifier value.
     * 
     * @throws InvalidArgumentException If the provided value is invalid.
     */
    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    /**
     * Generates a new unique UserId.
     * 
     * Uses a more robust UUID v4 generation for better uniqueness and standard compliance.
     * 
     * @return self A new instance of UserId with a generated unique value.
     */
    public static function generate(): self
    {
        return new self(self::generateUuidV4());
    }

    /**
     * Validates the provided identifier value.
     * 
     * Ensures that the ID is not empty and matches a valid UUID v4 format.
     * 
     * @param string $id The identifier value to validate.
     * 
     * @throws InvalidArgumentException If the identifier is empty or invalid.
     */
    private function validate(string $id): void
    {
        if (empty($id)) {
            throw new InvalidArgumentException('User ID cannot be empty.');
        }

        if (!self::isValidUuidV4($id)) {
            throw new InvalidArgumentException('Invalid User ID format. Expected a valid UUID v4.');
        }
    }

    /**
     * Returns the value of the UserId.
     * 
     * @return string The unique identifier value.
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
     * Compares this UserId with another UserId for equality.
     * 
     * @param UserId $anotherId The other UserId to compare with.
     * 
     * @return bool True if both UserIds have the same value, false otherwise.
     */
    public function equals(UserId $anotherId): bool
    {
        return $this->value === $anotherId->value;
    }

    /**
     * Generates a UUID v4 string.
     * 
     * Uses PHP's `random_bytes` and `bin2hex` functions to create a standards-compliant UUID v4.
     * 
     * @return string A valid UUID v4.
     */
    private static function generateUuidV4(): string
    {
        $data = random_bytes(16);

        // Set version to 0100 (UUID v4)
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);

        // Set variant to 10xx
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Validates if a string is a valid UUID v4.
     * 
     * @param string $uuid The string to validate.
     * 
     * @return bool True if the string is a valid UUID v4, false otherwise.
     */
    private static function isValidUuidV4(string $uuid): bool
    {
        return (bool) preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i',
            $uuid
        );
    }
}
