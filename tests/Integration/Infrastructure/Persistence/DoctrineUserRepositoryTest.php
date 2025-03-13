<?php

namespace Tests\Integration\Infrastructure\Persistence;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserId;
use App\Domain\Model\User\Email;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;


class DoctrineUserRepositoryTest extends TestCase
{
    private EntityManager $entityManager;
    private DoctrineUserRepository $repository;

    protected function setUp(): void
    {
        $this->entityManager = require __DIR__ . '/../../../../config/bootstrap.php';
        $this->repository = new DoctrineUserRepository($this->entityManager);

        // Start transaction
        $this->entityManager->beginTransaction();
    }

    protected function tearDown(): void
    {
        // Rollback transaction
        $this->entityManager->rollback();
    }

    public function testItSavesAndFindsUser(): void
    {
        // Arrange
        $user = User::create(
            'Integration Test',
            'integration@test.com',
            'StrongP@ss123'
        );

        // Act
        $this->repository->save($user);
        $foundUser = $this->repository->findById($user->id());

        // Assert
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id()->value(), $foundUser->id()->value());
        $this->assertEquals($user->email()->value(), $foundUser->email()->value());
    }

    public function testItFindsUserByEmail(): void
    {
        // Arrange
        $user = User::create(
            'Email Test',
            'email@test.com',
            'StrongP@ss123'
        );
        $this->repository->save($user);

        // Act
        $foundUser = $this->repository->findByEmail(new Email('email@test.com'));

        // Assert
        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id()->value(), $foundUser->id()->value());
    }

    public function testItReturnsNullWhenUserNotFound(): void
    {
        $uuid = Uuid::uuid4()->toString();
        $userId = new UserId($uuid);
        // Act
        $foundUser = $this->repository->findById(new UserId($userId));

        // Assert
        $this->assertNull($foundUser);
    }

    public function testItDeletesUser(): void
    {
        // Arrange
        $user = User::create(
            'Delete Test',
            'delete@test.com',
            'StrongP@ss123'
        );
        $this->repository->save($user);

        // Act
        $this->repository->delete($user->id());
        $foundUser = $this->repository->findById($user->id());

        // Assert
        $this->assertNull($foundUser);
    }
}
