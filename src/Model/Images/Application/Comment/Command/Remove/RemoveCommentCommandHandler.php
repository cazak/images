<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Comment\Command\Remove;

use App\Model\Images\Domain\Repository\Comment\CommentRepository;
use App\Model\Images\Domain\Repository\Post\PostRepository;
use App\Model\Images\Infrastructure\Repository\Post\RedisPostRepository;
use RedisException;

final class RemoveCommentCommandHandler
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly PostRepository $postRepository,
        private readonly RedisPostRepository $redisPostRepository,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function handle(RemoveCommentCommand $command): void
    {
        $comment = $this->commentRepository->get($command->commentId);
        $post = $this->postRepository->get($command->postId);

        $this->commentRepository->remove($comment);

        $this->redisPostRepository->reduceComments($post->getId()->getValue());
    }
}
