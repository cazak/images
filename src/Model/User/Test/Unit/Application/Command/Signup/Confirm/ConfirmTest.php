<?php

declare(strict_types=1);

namespace App\Model\User\Test\Unit\Application\Command\Signup\Confirm;

use App\Model\User\Domain\Entity\User;
use App\Model\User\Domain\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class ConfirmTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->factory = static::getContainer()->get(UserFactory::class);
    }

    public function test_success(): void
    {
        $user = $this->factory->registerUser('name', 'surname', 'test@test.test', 'password');

        self::assertFalse($user->isVerified());
        self::assertEquals(User::STATUS_WAIT, $user->getStatus());
        self::assertNotNull($user->getConfirmToken());

        // act
        $user->confirmSignUp();

        // assert
        self::assertTrue($user->isVerified());
        self::assertEquals(User::STATUS_ACTIVE, $user->getStatus());
        self::assertNull($user->getConfirmToken());
    }
}
