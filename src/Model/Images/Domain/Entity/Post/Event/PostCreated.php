<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Entity\Post\Event;

use App\Model\Shared\Domain\Entity\ValueObject\Id;
use App\Model\Shared\Domain\Event\Event;

final class PostCreated implements Event
{
    public function __construct(
        public readonly Id $authorId,
        public readonly Id $postId,
    ) {
    }
}
