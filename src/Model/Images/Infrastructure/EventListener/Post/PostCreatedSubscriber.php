<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\EventListener\Post;

use App\Model\Images\Domain\Entity\Post\Event\PostCreated;
use App\Model\Images\Domain\Factory\Feed\FeedFactory;
use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Model\Images\Domain\Repository\Feed\FeedRepository;
use App\Model\Images\Domain\Repository\Post\PostRepository;
use App\Model\Images\Infrastructure\Repository\Author\RedisAuthorRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;
use App\Service\ErrorHandler;
use RedisException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class PostCreatedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly FeedFactory $factory,
        private readonly RedisAuthorRepository $redisAuthorRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly PostRepository $postRepository,
        private readonly FeedRepository $feedRepository,
        private readonly ErrorHandler $errorHandler,
        private readonly Flusher $flusher,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PostCreated::class => 'onPostCreated',
        ];
    }

    public function onPostCreated(PostCreated $event): void
    {
        try {
            $author = $this->authorRepository->get($event->authorId->getValue());
            $post = $this->postRepository->get($event->postId->getValue());
            $followerIds = $this->redisAuthorRepository->getFollowers($event->authorId->getValue());
            $followers = $this->authorRepository->findAllByIds($followerIds);

            foreach ($followers as $follower) {
                $feed = $this->factory->create($follower, $author, $post);
                $this->feedRepository->add($feed);
            }

            $this->flusher->flush();
        } catch (RedisException $e) {
            $this->errorHandler->handle($e);
        }
    }
}
