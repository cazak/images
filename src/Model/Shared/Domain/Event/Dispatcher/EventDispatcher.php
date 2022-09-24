<?php

namespace App\Model\Shared\Domain\Event\Dispatcher;

interface EventDispatcher
{
    public function dispatch(array $events): void;
}
