<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\Signup\Confirm;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class ConfirmUserCommand
{
    #[Assert\NotBlank]
    public string $uri;

    #[Assert\NotBlank]
    public UserInterface $user;
}
