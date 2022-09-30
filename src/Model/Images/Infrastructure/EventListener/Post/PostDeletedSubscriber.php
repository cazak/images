<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\EventListener\Post;

use App\Model\Images\Domain\Entity\Post\Event\PostDeleted;
use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Model\Images\Domain\Repository\Comment\CommentRepository;
use App\Model\Images\Domain\Repository\Feed\FeedRepository;
use App\Model\Images\Domain\Repository\Post\PostRepository;
use App\Model\Images\Infrastructure\Repository\Author\RedisAuthorPostRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;
use App\Service\ErrorHandler;
use RedisException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class PostDeletedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RedisAuthorPostRepository $redisAuthorPostRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly PostRepository $postRepository,
        private readonly FeedRepository $feedRepository,
        private readonly CommentRepository $commentRepository,
        private readonly ErrorHandler $errorHandler,
        private readonly Flusher $flusher,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PostDeleted::class => 'onPostDeleted',
        ];
    }

    public function onPostDeleted(PostDeleted $event): void
    {
        try {
            $author = $this->authorRepository->get($event->authorId->getValue());
            $post = $this->postRepository->get($event->postId->getValue());

            $feedItems = $this->feedRepository->findAllByPost($post->getId()->getValue());
            $comments = $this->commentRepository->findAllByPost($post->getId()->getValue());

            foreach ($feedItems as $feedItem) {
                $this->feedRepository->remove($feedItem);
            }

            foreach ($comments as $comment) {
                $this->commentRepository->remove($comment);
            }

            $this->flusher->flush();
            $this->redisAuthorPostRepository->reducePosts($author->getId()->getValue());
        } catch (RedisException $e) {
            $this->errorHandler->handle($e);
        }
    }
}
