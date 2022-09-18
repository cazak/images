<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Factory;

use App\Model\Shared\Domain\Entity\ValueObject\Id;
use App\Model\User\Domain\Entity\Email;
use App\Model\User\Domain\Entity\Name;
use App\Model\User\Domain\Entity\User;
use App\Model\User\Domain\Service\ConfirmTokenGenerator;
use App\Model\User\Domain\Service\UserPasswordHasher;
use DateTimeImmutable;

final class UserFactory
{
    public function __construct(
        private readonly ConfirmTokenGenerator $generator,
        private readonly UserPasswordHasher $passwordHasher
    ) {
    }

    public function registerUser(string $name, string $surname, string $email, string $password): User
    {
        $user = new User(Id::next(), new Email($email), new DateTimeImmutable(), new Name($name, $surname));
        $passwordHash = $this->passwordHasher->hash($user, $password);
        $user
            ->setPassword($passwordHash)
            ->setConfirmToken($this->generator->generate())
            ->setRole(User::ROLE_USER);

        return $user;
    }
}
