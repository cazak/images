<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Application\Command\Create;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Images\Author\Infrastructure\Repository\RedisAuthorPostRepository;
use App\Model\Images\Shared\Service\FileUploader;
use App\Model\Images\Post\Domain\Entity\PostRepository;
use App\Model\Images\Post\Domain\Factory\PostFactory;
use App\Model\Shared\Infrastructure\Database\Flusher;
use App\Model\Shared\Infrastructure\Event\EventStarter;
use RedisException;

final class CreatePostCommandHandler
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly RedisAuthorPostRepository $redisAuthorPostRepository,
        private readonly FileUploader $fileUploader,
        private readonly PostFactory $factory,
        private readonly Flusher $flusher,
        private readonly EventStarter $eventStarter,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function handle(CreatePostCommand $command): string
    {
        $author = $this->authorRepository->get($command->authorId);

        $file = $this->fileUploader->upload($command->avatar);

        $post = $this->factory->create($author, $file, $command->description);

        $this->postRepository->add($post);

        $this->flusher->flush();

        $this->eventStarter->release($post);

        $this->redisAuthorPostRepository->increasePosts($author->getId()->getValue());

        return $post->getId()->getValue();
    }
}
