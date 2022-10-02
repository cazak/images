<?php

declare(strict_types=1);

namespace App\Model\Shared\Service;

final class UuidValidator
{
    public function validate(string $uuid): bool
    {
        return (bool) preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid);
    }
}
