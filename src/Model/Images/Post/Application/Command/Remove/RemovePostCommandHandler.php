<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Application\Command\Remove;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Post\Domain\Entity\PostRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;
use App\Model\Shared\Infrastructure\Event\EventStarter;

final class RemovePostCommandHandler
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly PostRepository $postRepository,
        private readonly Flusher $flusher,
        private readonly EventStarter $eventStarter,
    ) {
    }

    public function handle(RemovePostCommand $command): void
    {
        $author = $this->authorRepository->get($command->authorId);
        $post = $this->postRepository->get($command->postId);

        $post->delete($author);

        $this->eventStarter->release($post);
        $this->postRepository->remove($post);
        $this->flusher->flush();
    }
}
