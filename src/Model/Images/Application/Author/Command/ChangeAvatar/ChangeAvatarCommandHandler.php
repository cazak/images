<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Command\ChangeAvatar;

use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Model\Images\Infrastructure\Service\FileUploader;

final class ChangeAvatarCommandHandler
{
    public function __construct(private readonly AuthorRepository $repository, private readonly FileUploader $fileUploader)
    {
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

        $author->setAvatar($file);

        $this->repository->add($author);
    }
}
