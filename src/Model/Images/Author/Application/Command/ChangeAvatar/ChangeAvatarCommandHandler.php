<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Command\ChangeAvatar;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Shared\Service\FileUploader;
use App\Model\Shared\Infrastructure\Event\EventStarter;

final class ChangeAvatarCommandHandler
{
    public function __construct(
        private readonly AuthorRepository $repository,
        private readonly FileUploader $fileUploader,
        private readonly EventStarter $eventStarter,
    ) {
    }

    public function handle(ChangeAvatarCommand $command): void
    {
        $author = $this->repository->get($command->id);

        if ($author->getAvatar()) {
            $this->fileUploader->remove($author->getAvatar());
        }

        $file = null;
        if ($command->avatar) {
            $file = $this->fileUploader->upload($command->avatar);
        }

        $author->changeAvatar($file);

        $this->repository->add($author);

        $this->eventStarter->release($author);
    }
}
