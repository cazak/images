<?php

declare(strict_types=1);

namespace App\Model\Images\Shared\EventListener\Post;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Author\Infrastructure\Repository\RedisAuthorRepository;
use App\Model\Images\Feed\Domain\Entity\FeedRepository;
use App\Model\Images\Feed\Domain\Factory\FeedFactory;
use App\Model\Images\Post\Domain\Entity\Event\PostCreated;
use App\Model\Images\Post\Domain\Entity\PostRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class PostCreatedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly FeedFactory $factory,
        private readonly RedisAuthorRepository $redisAuthorRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly PostRepository $postRepository,
        private readonly FeedRepository $feedRepository,
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
        $author = $this->authorRepository->get($event->authorId->getValue());
        $post = $this->postRepository->get($event->postId->getValue());
        $followerIds = $this->redisAuthorRepository->getFollowers($event->authorId->getValue());
        $followers = $this->authorRepository->findAllByIds($followerIds);

        foreach ($followers as $follower) {
            $feed = $this->factory->create($follower, $author, $post);
            $this->feedRepository->add($feed);
        }

        $this->flusher->flush();
    }
}
