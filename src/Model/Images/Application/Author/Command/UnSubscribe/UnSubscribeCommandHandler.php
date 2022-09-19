<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Command\UnSubscribe;

use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Model\Images\Infrastructure\Repository\Author\RedisAuthorRepository;
use InvalidArgumentException;
use RedisException;

final class UnSubscribeCommandHandler
{
    public function __construct(
        private readonly RedisAuthorRepository $redisAuthorRepository,
        private readonly AuthorRepository $authorRepository,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function handle(UnSubscribeCommand $command): void
    {
        if (!$this->authorRepository->checkAuthorsExistForSubscribe($command->unSubscribingAuthorId, $command->unFollowingAuthorId)) {
            throw new InvalidArgumentException('Incorrect author id parameters.');
        }

        $this->redisAuthorRepository->unSubscribe($command->unSubscribingAuthorId, $command->unFollowingAuthorId);
    }
}
