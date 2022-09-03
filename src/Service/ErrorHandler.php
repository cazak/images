<?php

declare(strict_types=1);

namespace App\Service;

use Exception;
use Psr\Log\LoggerInterface;

final class ErrorHandler
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function handle(Exception $exception): void
    {
        $this->logger->warning($exception->getMessage(), ['exception' => $exception]);
    }
}
