<?php

namespace App\Tests\Domain\Model\User;

use App\Domain\Model\User\UserId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserIdTest extends TestCase
{
    public function testItCanBeCreatedFromString(): void
    {
        $uuid = Uuid::uuid4()->toString();
        $userId = new UserId($uuid);

        $this->assertEquals($uuid, $userId->value());
    }

    public function testItCanBeGenerated(): void
    {
        $userId = UserId::generate();

        // Verificar que el valor generado es un UUID v4 válido
        $this->assertTrue(Uuid::isValid($userId->value()));
    }

    public function testItCanBeCompared(): void
    {
        $uuid1 = Uuid::uuid4()->toString();
        $uuid2 = Uuid::uuid4()->toString();

        $userId1 = new UserId($uuid1);
        $userId2 = new UserId($uuid1); // Mismo UUID
        $userId3 = new UserId($uuid2); // UUID diferente

        $this->assertTrue($userId1->equals($userId2));
        $this->assertFalse($userId1->equals($userId3));
    }
}
