<?php

namespace Tests\Unit\Application\UseCase\RegisterUser;

use App\Application\UseCase\RegisterUser\RegisterUserRequest;
use App\Application\UseCase\RegisterUser\RegisterUserUseCase;
use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\Model\User\Email;
use App\Domain\Model\User\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\EventDispatcher\SimpleEventDispatcher;
use PHPUnit\Framework\TestCase;

class RegisterUserUseCaseTest extends TestCase
{
    private UserRepositoryInterface $userRepository;
    private SimpleEventDispatcher $eventDispatcher;
    private RegisterUserUseCase $useCase;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(SimpleEventDispatcher::class);
        $this->useCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
    }

    public function testItRegistersUser(): void
    {
        // Arrange
        $request = new RegisterUserRequest('John Doe', 'john@example.com', 'StrongP@ss123');

        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);

        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch');

        // Act
        $response = $this->useCase->execute($request);

        // Assert
        $this->assertEquals('John Doe', $response->toArray()['name']);
        $this->assertEquals('john@example.com', $response->toArray()['email']);
    }

    public function testItThrowsExceptionWhenUserExists(): void
    {
        // Arrange
        $request = new RegisterUserRequest('John Doe', 'john@example.com', 'StrongP@ss123');

        $existingUser = $this->createMock(User::class);

        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->willReturn($existingUser);

        // Assert
        $this->expectException(UserAlreadyExistsException::class);

        // Act
        $this->useCase->execute($request);
    }
}
