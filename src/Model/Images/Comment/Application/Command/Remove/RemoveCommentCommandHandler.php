<?php

declare(strict_types=1);

namespace App\Model\Images\Comment\Application\Command\Remove;

use App\Model\Images\Comment\Domain\Entity\CommentRepository;
use App\Model\Images\Post\Domain\Entity\PostRepository;
use App\Model\Images\Post\Infrastructure\Repository\RedisPostRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;
use RedisException;

final class RemoveCommentCommandHandler
{
    public function __construct(
        private readonly CommentRepository $commentRepository,
        private readonly Flusher $flusher,
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

        $this->flusher->flush();

        $this->redisPostRepository->reduceComments($post->getId()->getValue());
    }
}
