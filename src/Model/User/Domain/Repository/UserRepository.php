<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Repository;

use App\Model\User\Domain\Entity\User;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

interface UserRepository extends UserLoaderInterface
{
    public function add(User $entity, bool $flush = true): void;

    public function remove(User $entity, bool $flush = true): void;

    public function findByEmail(string $email): ?User;

    public function findByConfirmToken(string $token): ?User;
}
