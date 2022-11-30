<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Command\Subscribe;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Author\Infrastructure\Repository\RedisAuthorRepository;
use InvalidArgumentException;
use RedisException;

final class SubscribeCommandHandler
{
    public function __construct(
        private readonly RedisAuthorRepository $redisAuthorRepository,
        private readonly AuthorRepository $authorRepository,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function handle(SubscribeCommand $command): void
    {
        if (!$this->authorRepository->checkAuthorsExistForSubscribe($command->subscribingAuthorId, $command->followingAuthorId)) {
            throw new InvalidArgumentException('Incorrect author id parameters.');
        }

        $this->redisAuthorRepository->subscribe($command->subscribingAuthorId, $command->followingAuthorId);
    }
}
