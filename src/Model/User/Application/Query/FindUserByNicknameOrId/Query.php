<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\FindUserByNicknameOrId;

final class Query
{
    public function __construct(public readonly string $nicknameOrId)
    {
    }
}
