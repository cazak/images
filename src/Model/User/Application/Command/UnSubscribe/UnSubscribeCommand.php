<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\UnSubscribe;

final class UnSubscribeCommand
{
    public readonly string $unSubscribingUserId;
    public readonly string $unFollowingUserId;

    public function __construct(string $unSubscribingUserId, string $unFollowingUserId)
    {
        $this->unSubscribingUserId = $unSubscribingUserId;
        $this->unFollowingUserId = $unFollowingUserId;
    }
}
