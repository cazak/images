<?php

declare(strict_types=1);

namespace App\Model\User\Application\Service;

use App\Model\User\Domain\Service\ConfirmTokenGenerator as ConfirmTokenGeneratorInterface;
use Ramsey\Uuid\Uuid;

final class ConfirmTokenGenerator implements ConfirmTokenGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::uuid4()->toString();
    }
}
