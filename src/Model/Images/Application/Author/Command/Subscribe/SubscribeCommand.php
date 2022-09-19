<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Command\Subscribe;

final class SubscribeCommand
{
    public readonly string $subscribingAuthorId;
    public readonly string $followingAuthorId;

    public function __construct(string $subscribingAuthorId, string $followingAuthorId)
    {
        $this->subscribingAuthorId = $subscribingAuthorId;
        $this->followingAuthorId = $followingAuthorId;
    }
}
