<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\UpdateName;

use App\Model\Shared\Infrastructure\Database\Flusher;
use App\Model\Shared\Infrastructure\Event\EventStarter;
use App\Model\User\Domain\Entity\Name;
use App\Model\User\Domain\Repository\UserRepository;

final class UpdateNameCommandHandler
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly Flusher $flusher,
        private readonly EventStarter $eventStarter,
    ) {
    }

    public function handle(UpdateNameCommand $command): void
    {
        $user = $this->repository->get($command->id);

        $user->changeName(new Name($command->name, $command->surname));

        $this->flusher->flush();

        $this->eventStarter->release($user);
    }
}
