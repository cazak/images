<?php

declare(strict_types=1);

namespace App\Model\User\Infrastructure\Service;

use App\Model\User\Domain\Service\Assert as AssertInterface;
use Webmozart\Assert\Assert as WebmozartAssert;

final class Assert implements AssertInterface
{
    public function notEmpty(mixed $value): void
    {
        WebmozartAssert::notEmpty($value);
    }
}
