<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\Subscribe;

final class SubscribeCommand
{
    public readonly string $subscribingUserId;
    public readonly string $followingUserId;

    public function __construct(string $subscribingUserId, string $followingUserId)
    {
        $this->subscribingUserId = $subscribingUserId;
        $this->followingUserId = $followingUserId;
    }
}
