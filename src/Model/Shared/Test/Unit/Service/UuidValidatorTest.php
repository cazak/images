<?php

declare(strict_types=1);

namespace App\Model\Shared\Test\Unit\Service;

use App\Model\Shared\Service\UuidValidator;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UuidValidatorTest extends KernelTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = static::getContainer()->get(UuidValidator::class);
    }

    public function testSuccess(): void
    {
        $uuid = Uuid::uuid4()->toString();
        self::assertTrue($this->validator->validate($uuid));
    }

    public function testIncorrect(): void
    {
        $uuid = 'incorrect-uuid';
        self::assertFalse($this->validator->validate($uuid));
    }
}
