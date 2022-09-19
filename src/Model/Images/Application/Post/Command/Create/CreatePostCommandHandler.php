<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Command\Create;

use App\Model\Images\Domain\Factory\Post\PostFactory;
use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Model\Images\Domain\Repository\Post\PostRepository;
use App\Model\Images\Infrastructure\Service\FileUploader;

final class CreatePostCommandHandler
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly FileUploader $fileUploader,
        private readonly PostFactory $factory,
    ) {
    }

    public function handle(CreatePostCommand $command): string
    {
        $author = $this->authorRepository->get($command->authorId);

        $file = $this->fileUploader->upload($command->avatar);

        $post = $this->factory->create($author, $file, $command->description);

        $this->postRepository->add($post);

        return $post->getId()->getValue();
    }
}
