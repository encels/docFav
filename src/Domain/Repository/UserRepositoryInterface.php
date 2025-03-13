<?php

namespace App\Domain\Repository;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserId;
use App\Domain\Model\User\Email;

/**
 * Interface for the User repository.
 * 
 * Defines the contract for persisting, retrieving, and deleting User entities.
 */
interface UserRepositoryInterface
{
    /**
     * Saves a user to the repository.
     * 
     * @param User $user The user entity to save.
     * 
     * @return void
     */
    public function save(User $user): void;

    /**
     * Finds a user by their unique identifier.
     * 
     * @param UserId $id The unique identifier of the user.
     * 
     * @return User|null The user entity if found, or null if no user exists with the given ID.
     */
    public function findById(UserId $id): ?User;

    /**
     * Finds a user by their email address.
     * 
     * @param Email $email The email address of the user.
     * 
     * @return User|null The user entity if found, or null if no user exists with the given email.
     */
    public function findByEmail(Email $email): ?User;

    /**
     * Deletes a user by their unique identifier.
     * 
     * @param UserId $id The unique identifier of the user to delete.
     * 
     * @return void
     */
    public function delete(UserId $id): void;
}
