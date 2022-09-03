<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\Signup\Confirm;

use Symfony\Component\Validator\Constraints as Assert;

final class ConfirmUserCommand
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $token
    )
    {
    }
}
