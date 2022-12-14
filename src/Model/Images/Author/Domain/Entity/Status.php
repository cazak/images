<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Domain\Entity;

use App\Model\Shared\Infrastructure\Service\Assert;

final class Status
{
    private string $value;

    public const ACTIVE = 'active';
    public const BLOCKED = 'blocked';

    public function __construct(string $value)
    {
        Assert::oneOf($value, [
            self::ACTIVE,
            self::BLOCKED,
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
        return self::ACTIVE === $this->value;
    }

    public function isBlocked(): bool
    {
        return self::BLOCKED === $this->value;
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
