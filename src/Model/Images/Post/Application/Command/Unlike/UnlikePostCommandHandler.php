<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Application\Command\Unlike;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Post\Domain\Entity\PostRepository;
use App\Model\Images\Post\Infrastructure\Repository\RedisPostRepository;
use InvalidArgumentException;
use RedisException;

final class UnlikePostCommandHandler
{
    public function __construct(
        private readonly RedisPostRepository $redisPostRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly PostRepository $postRepository,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function handle(UnlikePostCommand $command): int
    {
        if ($this->authorRepository->hasById($command->authorId) && $this->postRepository->hasById($command->postId)) {
            $this->redisPostRepository->unlike($command->authorId, $command->postId);

            return $this->redisPostRepository->getLikesCount($command->postId);
        }

        throw new InvalidArgumentException('Incorrect author and post id parameters.');
    }
}
