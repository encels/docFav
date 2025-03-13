<?php

namespace Tests\Unit\Domain\Model\User;

use App\Domain\Model\User\User;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;


class UserTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $user = User::create(
            'John Doe',
            'john@example.com',
            'StrongP@ss123'
        );

        $this->assertEquals('John Doe', $user->name()->value());
        $this->assertEquals('john@example.com', $user->email()->value());
        $this->assertTrue($user->password()->verify('StrongP@ss123'));
        $this->assertInstanceOf(DateTimeImmutable::class, $user->createdAt());
    }
}
