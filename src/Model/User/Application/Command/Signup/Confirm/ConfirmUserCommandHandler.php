<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\Signup\Confirm;

use App\Model\User\Domain\Entity\User;
use App\Model\User\Domain\Repository\UserRepository;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class ConfirmUserCommandHandler
{
    public function __construct(
        private readonly VerifyEmailHelperInterface $verifyEmailHelper,
        private readonly UserRepository             $repository
    )
    {
    }

    /**
     * @throws VerifyEmailExceptionInterface
     */
    public function handle(ConfirmUserCommand $command): void
    {
        /** @var User $user */
        $user = $command->user;
        $this->verifyEmailHelper->validateEmailConfirmation($command->uri, $user->getId()->getValue(), $user->getEmail()->getValue());

        $user->setIsVerified(true);

        $this->repository->add($user);
    }
}
