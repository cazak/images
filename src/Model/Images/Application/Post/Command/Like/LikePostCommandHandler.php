<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Command\Like;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Domain\Repository\Post\PostRepository;
use App\Model\Images\Infrastructure\Repository\Post\RedisPostRepository;
use InvalidArgumentException;
use RedisException;

final class LikePostCommandHandler
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
    public function handle(LikePostCommand $command): int
    {
        if ($this->authorRepository->hasById($command->authorId) && $this->postRepository->hasById($command->postId)) {
            $this->redisPostRepository->like($command->authorId, $command->postId);

            return $this->redisPostRepository->getLikesCount($command->postId);
        }

        throw new InvalidArgumentException('Incorrect author and post id parameters.');
    }
}
