<?php

declare(strict_types=1);

namespace App\Model\Images\Feed\Application\Query\GetFeedByReader;

final class Query
{
    public function __construct(public readonly string $readerId, public readonly int $page)
    {
    }
}
