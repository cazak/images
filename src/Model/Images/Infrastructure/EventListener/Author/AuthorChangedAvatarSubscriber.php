<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\EventListener\Author;

use App\Model\Images\Domain\Entity\Author\Event\AuthorAvatarChanged;
use App\Model\Images\Domain\Entity\Feed\Author;
use App\Model\Images\Domain\Entity\Feed\AuthorName;
use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Model\Images\Domain\Repository\Feed\FeedRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class AuthorChangedAvatarSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly FeedRepository $feedRepository,
        private readonly Flusher $flusher,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AuthorAvatarChanged::class => 'onAuthorAvatarChanged',
        ];
    }

    public function onAuthorAvatarChanged(AuthorAvatarChanged $event): void
    {
        $author = $this->authorRepository->get($event->id->getValue());
        $feedItems = $this->feedRepository->findAllByAuthor($author->getId()->getValue());

        foreach ($feedItems as $feedItem) {
            $feedItem->setAuthorData(
                new Author(
                    new AuthorName($author->getName()->getSurname(), $author->getName()->getSurname()),
                    $author->getNickname(),
                    $author->getAvatar(),
                )
            );
        }

        $this->flusher->flush();
    }
}