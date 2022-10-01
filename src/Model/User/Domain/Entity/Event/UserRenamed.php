<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Entity\Event;

use App\Model\Shared\Domain\Entity\ValueObject\Id;
use App\Model\Shared\Domain\Event\Event;
use App\Model\User\Domain\Entity\Name;

final class UserRenamed implements Event
{
    public function __construct(
        public readonly Id $id,
        public readonly Name $name
    ) {
    }
}
