<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Service;

use App\Model\User\Domain\Entity\User;

interface UserPasswordHasher
{
    public function hash(User $user, string $password): string;
}
