<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Query\GetAuthorByNicknameOrId;

final class Query
{
    public function __construct(public readonly string $nicknameOrId)
    {
    }
}
