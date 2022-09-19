<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Entity\Author;

use App\Model\Shared\Infrastructure\Service\Assert;

final class Status
{
    private string $value;

    const ACTIVE = 'active';
    const BLOCKED = 'blocked';

    public function __construct(string $value)
    {
        Assert::oneOf($value, [
            self::ACTIVE,
            self::BLOCKED
        ]);
        $this->value = $value;
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public static function blocked(): self
    {
        return new self(self::BLOCKED);
    }

    public function isActive(): bool
    {
        return $this->value === self::ACTIVE;
    }

    public function isBlocked(): bool
    {
        return $this->value === self::BLOCKED;
    }

    public function isEqual(self $status): bool
    {
        return $this->getValue() === $status->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
