<?php

declare(strict_types=1);

namespace App\Model\Shared\Infrastructure\Database;

use App\Model\Shared\Domain\Entity\AggregateRoot;
use App\Model\Shared\Domain\Event\Dispatcher\EventDispatcher;
use Doctrine\ORM\EntityManagerInterface;

final class Flusher
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly EventDispatcher $dispatcher)
    {
    }

    public function flush(AggregateRoot ...$roots): void
    {
        $this->entityManager->flush();

        foreach ($roots as $root) {
            $this->dispatcher->dispatch($root->releaseEvents());
        }
    }
}
