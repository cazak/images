<?php

declare(strict_types=1);

namespace App\Model\Shared\Infrastructure\Event;

use App\Model\Shared\Domain\Entity\AggregateRoot;
use App\Model\Shared\Domain\Event\Dispatcher\EventDispatcher;

final class EventStarter
{
    public function __construct(private readonly EventDispatcher $dispatcher)
    {
    }

    public function release(AggregateRoot ...$roots): void
    {
        foreach ($roots as $root) {
            $this->dispatcher->dispatch($root->releaseEvents());
        }
    }
}
