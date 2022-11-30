<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Domain\Entity\Event;

use App\Model\Shared\Domain\Entity\ValueObject\Id;
use App\Model\Shared\Domain\Event\Event;

final class AuthorAvatarChanged implements Event
{
    public function __construct(
        public readonly Id $id,
        public readonly string $avatar,
    ) {
    }
}
