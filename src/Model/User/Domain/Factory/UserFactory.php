<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Factory;

use App\Model\User\Application\Service\ConfirmTokenGenerator;
use App\Model\User\Domain\Entity\Email;
use App\Model\User\Domain\Entity\Id;
use App\Model\User\Domain\Entity\User;
use App\Model\User\Domain\Service\UserPasswordHasher;

final class UserFactory
{
    public function __construct(
        private readonly ConfirmTokenGenerator $generator,
        private readonly UserPasswordHasher    $passwordHasher
    )
    {
    }

    public function registerUser(string $name, string $email, string $password): User
    {
        $user = new User(Id::next(), new Email($email), new \DateTimeImmutable(), $name);
        $passwordHash = $this->passwordHasher->hash($user, $password);
        $user
            ->setPassword($passwordHash)
            ->setConfirmToken($this->generator->generate())
            ->setRole(User::ROLE_USER);

        return $user;
    }
}
