<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Command\Create;

use App\Model\Images\Application\Author\Command\Exceptions\NicknameIsAlreadyInUse;
use App\Model\Images\Domain\Factory\Author\AuthorFactory;
use App\Model\Images\Domain\Repository\Author\AuthorRepository;

final class CreateAuthorCommandHandler
{
    public function __construct(private readonly AuthorRepository $repository, private readonly AuthorFactory $factory)
    {
    }

    /**
     * @throws NicknameIsAlreadyInUse
     */
    public function handle(CreateAuthorCommand $command): void
    {
        if ($this->repository->existByNickname($command->nickname)) {
            throw new NicknameIsAlreadyInUse();
        }

        $author = $this->factory->create($command->id, $command->name, $command->surname, $command->nickname);

        $this->repository->add($author);
    }
}
