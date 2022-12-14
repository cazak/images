<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Command\EditAbout;

use App\Model\Images\Author\Domain\Entity\AuthorRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;

final class EditAboutCommandHandler
{
    public function __construct(private readonly AuthorRepository $authorRepository, private readonly Flusher $flusher)
    {
    }

    public function handle(EditAboutCommand $command): void
    {
        $author = $this->authorRepository->get($command->id);

        $author->setAbout($command->about);

        $this->flusher->flush();
    }
}
