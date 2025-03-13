<?php

namespace Tests\Unit\Domain\Model\User;

use App\Domain\Exception\WeakPasswordException;
use App\Domain\Model\User\Password;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $password = new Password('StrongP@ss123');
        $this->assertNotEmpty($password->value());
    }

    public function testItThrowsExceptionForTooShortPassword(): void
    {
        $this->expectException(WeakPasswordException::class);
        new Password('Short1!');
    }

    public function testItThrowsExceptionForPasswordWithoutUppercase(): void
    {
        $this->expectException(WeakPasswordException::class);
        new Password('password123!');
    }

    public function testItThrowsExceptionForPasswordWithoutNumber(): void
    {
        $this->expectException(WeakPasswordException::class);
        new Password('Password!');
    }

    public function testItThrowsExceptionForPasswordWithoutSpecialChar(): void
    {
        $this->expectException(WeakPasswordException::class);
        new Password('Password123');
    }

    public function testItCanVerifyPassword(): void
    {
        $password = new Password('StrongP@ss123');
        $this->assertTrue($password->verify('StrongP@ss123'));
        $this->assertFalse($password->verify('WrongPassword'));
    }
}
