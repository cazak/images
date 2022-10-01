<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\UpdateName;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateNameCommand
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    public string $surname;

    public function __construct(public readonly string $id)
    {
    }
}
