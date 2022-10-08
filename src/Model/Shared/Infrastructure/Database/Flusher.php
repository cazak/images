<?php

declare(strict_types=1);

namespace App\Model\Shared\Infrastructure\Database;

use Doctrine\ORM\EntityManagerInterface;

final class Flusher
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
