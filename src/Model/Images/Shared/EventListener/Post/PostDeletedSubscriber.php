<?php

declare(strict_types=1);

namespace App\Model\Images\Shared\EventListener\Post;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Author\Infrastructure\Repository\RedisAuthorPostRepository;
use App\Model\Images\Comment\Domain\Entity\CommentRepository;
use App\Model\Images\Feed\Domain\Entity\FeedRepository;
use App\Model\Images\Post\Domain\Entity\Event\PostDeleted;
use App\Model\Images\Post\Domain\Entity\PostRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class PostDeletedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RedisAuthorPostRepository $redisAuthorPostRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly PostRepository $postRepository,
        private readonly FeedRepository $feedRepository,
        private readonly CommentRepository $commentRepository,
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
    }
}
