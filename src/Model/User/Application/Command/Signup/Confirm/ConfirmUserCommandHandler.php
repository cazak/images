<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\Signup\Confirm;

use App\Model\User\Domain\Entity\User;
use App\Model\User\Domain\Repository\UserRepository;

final class ConfirmUserCommandHandler
{
    public function __construct(
        private readonly UserRepository $repository
    ) {
    }

    public function handle(ConfirmUserCommand $command): User
    {
        $user = $this->repository->findByConfirmToken($command->token);

        if (!$user) {
            throw new \DomainException('User is not registered.');
        }
        $user->confirmSignUp();

        $this->repository->add($user);

        return $user;
    }
}
