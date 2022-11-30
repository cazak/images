<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Command\Create;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateAuthorCommand
{
    #[Assert\NotBlank]
    public string $id;

    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    public string $surname;

    #[Assert\NotBlank]
    public string $nickname;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
