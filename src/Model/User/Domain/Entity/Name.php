<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class Name
{
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $surname;

    public function __construct(string $name, ?string $surname)
    {
        Assert::notEmpty($name);
        Assert::notEmpty($surname);

        $this->name = $name;
        $this->surname = $surname;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }
}
