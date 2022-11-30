<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Command\Create;

use App\Model\Images\Author\Application\Command\Exceptions\NicknameIsAlreadyInUse;
use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Author\Domain\Factory\AuthorFactory;

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
