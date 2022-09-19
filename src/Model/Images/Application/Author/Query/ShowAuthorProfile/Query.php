<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Query\ShowAuthorProfile;

final class Query
{
    public function __construct(public readonly string $nicknameOrId, public readonly string $currentAuthorId)
    {
    }
}
