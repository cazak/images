<?php

declare(strict_types=1);

namespace App\Model\User\Infrastructure\Service;

use App\Model\User\Domain\Service\UserPasswordHasher as UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as BaseUserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

final class UserPasswordHasher implements UserPasswordHasherInterface
{
    public function __construct(private readonly BaseUserPasswordHasherInterface $passwordHasher)
    {
    }

    public function hash(PasswordAuthenticatedUserInterface $user, string $password): string
    {
        return $this->passwordHasher->hashPassword($user, $password);
    }
}
