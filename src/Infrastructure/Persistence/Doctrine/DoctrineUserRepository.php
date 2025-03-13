<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserId;
use App\Domain\Model\User\Email;
use App\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;

/**
 * Doctrine implementation of the UserRepositoryInterface.
 * 
 * This repository uses Doctrine ORM to manage User entities in the database.
 */
final class DoctrineUserRepository implements UserRepositoryInterface
{
    /**
     * @var EntityManagerInterface The Doctrine EntityManager instance.
     */
    private EntityManagerInterface $entityManager;

    /**
     * Constructor for the DoctrineUserRepository.
     * 
     * @param EntityManagerInterface $entityManager The Doctrine EntityManager.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Saves a user to the database.
     * 
     * @param User $user The user to save.
     * 
     * @return void
     * 
     * @throws ORMException If an error occurs during the save operation.
     */
    public function save(User $user): void
    {
        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            // Log the error or rethrow it as needed
            throw $e;
        }
    }

    /**
     * Finds a user by their ID.
     * 
     * @param UserId $id The ID of the user to find.
     * 
     * @return User|null The user, or null if not found.
     */
    public function findById(UserId $id): ?User
    {
        return $this->entityManager->find(User::class, $id->value());
    }

    /**
     * Finds a user by their email address.
     * 
     * @param Email $email The email of the user to find.
     * 
     * @return User|null The user, or null if not found.
     */
    public function findByEmail(Email $email): ?User
    {
        return $this->entityManager->getRepository(User::class)
            ->findOneBy(['email.value' => $email->value()]);
    }

    /**
     * Deletes a user by their ID.
     * 
     * @param UserId $id The ID of the user to delete.
     * 
     * @return void
     * 
     * @throws ORMException If an error occurs during the delete operation.
     */
    public function delete(UserId $id): void
    {
        try {
            $user = $this->findById($id);
            if ($user !== null) {
                $this->entityManager->remove($user);
                $this->entityManager->flush();
            }
        } catch (ORMException $e) {
            // Log the error or rethrow it as needed
            throw $e;
        }
    }
}
