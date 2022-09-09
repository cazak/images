<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\Signup\Request;

use App\Model\User\Application\Service\SignupSender;
use App\Model\User\Domain\Factory\UserFactory;
use App\Model\User\Domain\Repository\UserRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

final class CreateUserCommandHandler
{
    public function __construct(
        private readonly SignupSender $sender,
        private readonly UserFactory $factory,
        private readonly UserRepository $repository
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function handle(CreateUserCommand $command): void
    {
        if ($this->repository->findByEmail($command->email)) {
            throw new \DomainException('This email is already in use.');
        }

        $user = $this->factory->registerUser($command->name, $command->surname, $command->email, $command->password);
        $this->repository->add($user);

        $this->sender->send($command->email, $user->getConfirmToken());
    }
}
