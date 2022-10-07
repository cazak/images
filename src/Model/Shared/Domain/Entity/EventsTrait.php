<?php

namespace App\Model\Shared\Domain\Entity;

trait EventsTrait
{
    private array $recordedEvents = [];

    protected function recordEvent(object $event): void
    {
        $this->recordedEvents[] = $event;
    }

    public function releaseEvents(): array
    {
        return $this->recordedEvents + $this->recordedEvents = [];
    }
}
