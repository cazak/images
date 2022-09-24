<?php

declare(strict_types=1);

namespace App\Model\Shared\Infrastructure\Event\Dispatcher\Message;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class Handler
{
    public function __construct(private readonly EventDispatcherInterface $dispatcher)
    {
    }

    public function __invoke(Message $message): void
    {
        $this->dispatcher->dispatch($message->getEvent());
    }
}
