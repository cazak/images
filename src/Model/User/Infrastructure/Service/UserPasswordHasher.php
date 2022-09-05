<?php

declare(strict_types=1);

namespace App\Model\User\Infrastructure\Service;

use App\Model\User\Domain\Entity\User;
use App\Model\User\Domain\Service\UserPasswordHasher as UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as BaseUserPasswordHasherInterface;

final class UserPasswordHasher implements UserPasswordHasherInterface
{
    public function __construct(private readonly BaseUserPasswordHasherInterface $passwordHasher)
    {
    }

    public function hash(User $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }
}
