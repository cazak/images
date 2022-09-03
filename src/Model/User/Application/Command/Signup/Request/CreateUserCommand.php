<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\Signup\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateUserCommand
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6)]
    public string $password;
}
