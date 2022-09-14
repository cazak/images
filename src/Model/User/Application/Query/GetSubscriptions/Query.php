<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetSubscriptions;

final class Query
{
    public function __construct(public readonly string $userId)
    {
    }
}
