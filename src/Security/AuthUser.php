<?php

declare(strict_types=1);

namespace App\Security;

final class AuthUser
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $role,
        public readonly string $email,
        public readonly string $password,
    ) {
    }
}
