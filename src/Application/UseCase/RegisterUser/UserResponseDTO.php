<?php

namespace App\Application\UseCase\RegisterUser;

use App\Domain\Model\User\User;

/**
 * Data Transfer Object (DTO) for returning user details in a response.
 * 
 * This class encapsulates the data of a user to be sent as part of a response,
 * ensuring consistency and a clear structure.
 */
final class UserResponseDTO
{
    /**
     * @var string The unique ID of the user.
     */
    private string $id;

    /**
     * @var string The name of the user.
     */
    private string $name;

    /**
     * @var string The email of the user.
     */
    private string $email;

    /**
     * @var string The creation timestamp of the user, formatted as 'Y-m-d H:i:s'.
     */
    private string $createdAt;

    /**
     * UserResponseDTO constructor.
     * 
     * @param User $user The user entity from which to extract data.
     */
    public function __construct(User $user)
    {
        $this->id = $user->id()->value();
        $this->name = $user->name()->value();
        $this->email = $user->email()->value();
        $this->createdAt = $user->createdAt()->format('Y-m-d H:i:s');
    }

    /**
     * Converts the DTO to an associative array.
     * 
     * @return array An associative array containing user details.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->createdAt,
        ];
    }
}
