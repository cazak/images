<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Feed\Query\GetFeedByReader;

final class Query
{
    public function __construct(public readonly string $readerId)
    {
    }
}
