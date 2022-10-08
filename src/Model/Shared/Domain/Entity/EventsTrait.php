<?php

namespace App\Model\Shared\Domain\Entity;

use App\Model\Shared\Domain\Event\Event;

trait EventsTrait
{
    /**
     * @var Event[]
     */
    private array $recordedEvents = [];

    protected function recordEvent(Event $event): void
    {
        $this->recordedEvents[] = $event;
    }

    /**
     * @return Event[]
     */
    public function releaseEvents(): array
    {
        return $this->recordedEvents + $this->recordedEvents = [];
    }
}
