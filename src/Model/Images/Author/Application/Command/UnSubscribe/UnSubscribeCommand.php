<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Command\UnSubscribe;

final class UnSubscribeCommand
{
    public readonly string $unSubscribingAuthorId;
    public readonly string $unFollowingAuthorId;

    public function __construct(string $unSubscribingAuthorId, string $unFollowingAuthorId)
    {
        $this->unSubscribingAuthorId = $unSubscribingAuthorId;
        $this->unFollowingAuthorId = $unFollowingAuthorId;
    }
}
