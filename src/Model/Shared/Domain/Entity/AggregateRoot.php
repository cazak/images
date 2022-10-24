<?php

namespace App\Model\Shared\Domain\Entity;

use App\Model\Shared\Domain\Event\Event;

interface AggregateRoot
{
    /**
     * @return Event[]
     */
    public function releaseEvents(): array;
}
