<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Factory;

use App\Model\User\Domain\Entity\Email;
use App\Model\User\Domain\Entity\Id;
use App\Model\User\Domain\Entity\User;
use App\Model\User\Domain\Service\UserPasswordHasher;

final class UserFactory
{
    public function __construct(private readonly UserPasswordHasher $passwordHasher)
    {
    }

    public function create(string $name, string $email, string $password): User
    {
        $user = new User();
        $passwordHash = $this->passwordHasher->hash($user, $password);
        $user->setId(Id::next());
        $user->setPassword($passwordHash);
        $user->setStatus(User::STATUS_ACTIVE);
        $user->setRole(User::ROLE_USER);
        $user->setName($name);
        $user->setEmail(new Email($email));
        $user->setDate(new \DateTimeImmutable());

        return $user;
    }
}
