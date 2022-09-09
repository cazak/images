<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetUserByNicknameOrId;

final class DTO
{
    public function __construct(public string $id, public string $name, public ?string $nickname)
    {
    }

    public static function fromUser($user): self
    {
        return new self($user['id'], $user['name'], $user['nickname']);
    }
}
