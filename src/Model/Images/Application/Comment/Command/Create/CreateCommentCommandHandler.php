<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Comment\Command\Create;

use App\Model\Images\Domain\Factory\Comment\CommentFactory;
use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Model\Images\Domain\Repository\Comment\CommentRepository;
use App\Model\Images\Domain\Repository\Post\PostRepository;
use App\Model\Images\Infrastructure\Repository\Post\RedisPostRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;
use RedisException;

final class CreateCommentCommandHandler
{
    public function __construct(
        private readonly CommentFactory $factory,
        private readonly CommentRepository $commentRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly PostRepository $postRepository,
        private readonly RedisPostRepository $redisPostRepository,
        private readonly Flusher $flusher,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function handle(CreateCommentCommand $command): string
    {
        $post = $this->postRepository->get($command->postId);
        $author = $this->authorRepository->get($command->authorId);

        $comment = $this->factory->create($post, $author, $command->text);

        $this->commentRepository->add($comment);
        $this->flusher->flush();

        $this->redisPostRepository->increaseComments($post->getId()->getValue());

        return $comment->getId()->getValue();
    }
}
