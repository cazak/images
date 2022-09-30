<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Entity\Post\Event;

use App\Model\Shared\Domain\Entity\ValueObject\Id;
use App\Model\Shared\Domain\Event\Event;

final class PostDeleted implements Event
{
    public function __construct(public readonly Id $postId, public readonly Id $authorId)
    {
    }
}
