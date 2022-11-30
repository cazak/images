<?php

declare(strict_types=1);

namespace App\Model\Images\Shared\EventListener\Author;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Author\Domain\Entity\Event\AuthorAvatarChanged;
use App\Model\Images\Feed\Domain\Entity\Author;
use App\Model\Images\Feed\Domain\Entity\AuthorName;
use App\Model\Images\Feed\Domain\Entity\FeedRepository;
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
