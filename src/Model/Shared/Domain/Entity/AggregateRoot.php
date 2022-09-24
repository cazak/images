<?php

namespace App\Model\Shared\Domain\Entity;

interface AggregateRoot
{
    public function releaseEvents(): array;
}
