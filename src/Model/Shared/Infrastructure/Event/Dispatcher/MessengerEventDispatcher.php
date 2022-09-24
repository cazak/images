<?php

declare(strict_types=1);

namespace App\Model\Shared\Infrastructure\Event\Dispatcher;

use App\Model\Shared\Domain\Event\Dispatcher\EventDispatcher;
use App\Model\Shared\Infrastructure\Event\Dispatcher\Message\Message;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEventDispatcher implements EventDispatcher
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    public function dispatch(array $events): void
    {
        foreach ($events as $event) {
            $this->bus->dispatch(new Message($event));
        }
    }
}
