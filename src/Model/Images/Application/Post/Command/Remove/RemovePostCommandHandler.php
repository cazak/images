<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Command\Remove;

use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Model\Images\Domain\Repository\Post\PostRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;

final class RemovePostCommandHandler
{
    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly PostRepository $postRepository,
        private readonly Flusher $flusher,
    ) {
    }

    public function handle(RemovePostCommand $command): void
    {
        $author = $this->authorRepository->get($command->authorId);
        $post = $this->postRepository->get($command->postId);

        $post->delete($author);

        $this->postRepository->remove($post);
        $this->flusher->flush($post);
    }
}
