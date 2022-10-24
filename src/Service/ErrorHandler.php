<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Log\LoggerInterface;
use Throwable;

final class ErrorHandler
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function handle(Throwable $exception): void
    {
        $this->logger->warning($exception->getMessage(), ['exception' => $exception]);
    }
}
