<?php

declare(strict_types=1);

namespace App\Model\User\Test\Unit\Domain\Factory;

use App\Model\User\Domain\Entity\Id;
use App\Model\User\Domain\Entity\User;
use App\Model\User\Domain\Factory\UserFactory;
use App\Model\User\Domain\Service\UserPasswordHasher;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FactoryTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->factory = static::getContainer()->get(UserFactory::class);
        $this->passwordHasher = static::getContainer()->get(UserPasswordHasher::class);
    }

    public function testSuccess(): void
    {
        $name = 'name';
        $email = 'email@email.com';
        $password = 'qwerty';

        // act
        $user = $this->factory->registerUser($name, $email, $password);

        // assert
        self::assertEquals($name, $user->getName());
        self::assertEquals($email, $user->getEmail()->getValue());
        self::assertEquals(User::STATUS_WAIT, $user->getStatus());
        self::assertNotNull($user->getDate());
        self::assertNotNull($user->getConfirmToken());
        self::assertNotNull($user->getRole());
        self::assertInstanceOf(Id::class, $user->getId());
        self::assertFalse($user->isVerified());
    }
}
