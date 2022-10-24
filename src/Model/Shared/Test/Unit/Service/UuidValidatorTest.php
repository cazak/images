<?php

declare(strict_types=1);

namespace App\Model\Shared\Test\Unit\Service;

use App\Model\Shared\Service\UuidValidator;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 */
final class UuidValidatorTest extends KernelTestCase
{
    private UuidValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = self::getContainer()->get(UuidValidator::class);
    }

    public function test_success(): void
    {
        $uuid = Uuid::uuid4()->toString();
        self::assertTrue($this->validator->validate($uuid));
    }

    public function test_incorrect(): void
    {
        $uuid = 'incorrect-uuid';
        self::assertFalse($this->validator->validate($uuid));
    }
}
