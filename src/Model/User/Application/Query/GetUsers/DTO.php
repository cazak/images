<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetUsers;

final class DTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly ?string $nickname,
        public readonly int $status,
    ) {
    }

    public static function fromUser(array $user): self
    {
        return new self($user['id'], $user['name'], $user['nickname'], $user['status']);
    }
}
