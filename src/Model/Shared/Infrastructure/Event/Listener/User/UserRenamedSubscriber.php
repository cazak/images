<?php

declare(strict_types=1);

namespace App\Model\Shared\Infrastructure\Event\Listener\User;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Author\Domain\Entity\Name;
use App\Model\Shared\Infrastructure\Database\Flusher;
use App\Model\User\Domain\Entity\Event\UserRenamed;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class UserRenamedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly Flusher $flusher,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserRenamed::class => 'onUserRenamed',
        ];
    }

    public function onUserRenamed(UserRenamed $event): void
    {
        $author = $this->authorRepository->get($event->id->getValue());

        $author->rename(new Name($event->name->getName(), $event->name->getSurname()));

        $this->flusher->flush();
    }
}
