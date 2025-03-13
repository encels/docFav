<?php

namespace Tests\Unit\Domain\Model\User;

use App\Domain\Exception\InvalidEmailException;
use App\Domain\Model\User\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $email = new Email('test@example.com');
        $this->assertEquals('test@example.com', $email->value());
    }

    public function testItThrowsExceptionForInvalidEmail(): void
    {
        $this->expectException(InvalidEmailException::class);
        new Email('invalid-email');
    }

    public function testItCanBeCompared(): void
    {
        $email1 = new Email('test@example.com');
        $email2 = new Email('test@example.com');
        $email3 = new Email('other@example.com');

        $this->assertTrue($email1->equals($email2));
        $this->assertFalse($email1->equals($email3));
    }
}
