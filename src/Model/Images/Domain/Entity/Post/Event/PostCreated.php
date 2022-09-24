<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Entity\Post\Event;

use App\Model\Shared\Domain\Entity\ValueObject\Id;
use App\Model\Shared\Domain\Event\Event;
use DateTimeImmutable;

final class PostCreated implements Event
{
    public function __construct(
        public readonly Id $authorId,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $nickname,

        public readonly Id $postId,
        public readonly string $avatar,
        public readonly string $description,
        DateTimeImmutable $date
    ) {
    }
}
