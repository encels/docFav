<?php

namespace Tests\Unit\Domain\Model\User;

use App\Domain\Model\User\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $name = new Name('John Doe');
        $this->assertEquals('John Doe', $name->value());
    }

    public function testItThrowsExceptionForEmptyName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Name('');
    }

    public function testItThrowsExceptionForTooShortName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Name('A');
    }

    public function testItThrowsExceptionForInvalidCharacters(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Name('John123');
    }
}
