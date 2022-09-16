<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\ChangeAvatar;

use App\Model\Shared\Infrastructure\Service\FileUploader;
use App\Model\User\Domain\Repository\UserRepository;

final class ChangeAvatarCommandHandler
{
    public function __construct(private readonly UserRepository $repository, private readonly FileUploader $fileUploader)
    {
    }

    public function handle(ChangeAvatarCommand $command): void
    {
        $user = $this->repository->get($command->id);

        if ($user->getAvatar()) {
            $this->fileUploader->remove($user->getAvatar());
        }

        $file = null;
        if ($command->avatar) {
            $file = $this->fileUploader->upload($command->avatar);
        }

        $user->setAvatar($file);

        $this->repository->add($user);
    }
}
