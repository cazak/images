<?php

declare(strict_types=1);

namespace App\Model\User\Test\Unit\Domain\Factory;

use App\Model\User\Domain\Entity\Id;
use App\Model\User\Domain\Entity\Name;
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

    public function test_success(): void
    {
        $name = 'name';
        $surname = 'surname';
        $email = 'email@email.com';
        $password = 'qwerty';

        // act
        $user = $this->factory->registerUser($name, $surname, $email, $password);

        // assert
        self::assertInstanceOf(Name::class, $user->getName());
        self::assertEquals($name, $user->getName()->getName());
        self::assertEquals($surname, $user->getName()->getSurname());
        self::assertEquals($email, $user->getEmail()->getValue());
        self::assertEquals(User::STATUS_WAIT, $user->getStatus());
        self::assertNotNull($user->getDate());
        self::assertNotNull($user->getConfirmToken());
        self::assertNotNull($user->getRole());
        self::assertInstanceOf(Id::class, $user->getId());
        self::assertFalse($user->isVerified());
    }
}
