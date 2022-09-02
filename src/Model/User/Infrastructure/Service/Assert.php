<?php

declare(strict_types=1);

namespace App\Model\User\Infrastructure\Service;

use App\Model\User\Domain\Service\Assert as AssertInterface;
use Webmozart\Assert\Assert as WebmozartAssert;

class Assert implements AssertInterface
{
    public function notEmpty($value): void
    {
        WebmozartAssert::notEmpty($value);
    }
}
