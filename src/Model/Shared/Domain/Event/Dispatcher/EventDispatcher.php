<?php

namespace App\Model\Shared\Domain\Event\Dispatcher;

use App\Model\Shared\Domain\Event\Event;

interface EventDispatcher
{
    /**
     * @param Event[] $events
     */
    public function dispatch(array $events): void;
}
