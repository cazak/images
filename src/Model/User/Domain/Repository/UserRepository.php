<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Repository;

use App\Model\User\Domain\Entity\User;

interface UserRepository
{
    public function add(User $entity, bool $flush = true): void;

    public function remove(User $entity, bool $flush = true): void;

    public function get(string $id): User;

    public function findByEmail(string $email): ?User;

    public function findByConfirmToken(string $token): ?User;

    public function checkUsersExistForSubscribe(string $firstUserId, string $secondUserId): bool;
}
