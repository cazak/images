<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Entity;

use Webmozart\Assert\Assert;
use Ramsey\Uuid\Uuid;

class Id
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function next(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
