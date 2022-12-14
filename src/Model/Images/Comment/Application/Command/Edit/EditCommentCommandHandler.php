<?php

declare(strict_types=1);

namespace App\Model\Images\Comment\Application\Command\Edit;

use App\Model\Images\Comment\Domain\Entity\CommentRepository;
use App\Model\Shared\Infrastructure\Database\Flusher;
use DateTimeImmutable;

final class EditCommentCommandHandler
{
    public function __construct(
        private readonly CommentRepository $repository,
        private readonly Flusher $flusher,
    ) {
    }

    public function handle(EditCommentCommand $command): string
    {
        $comment = $this->repository->get($command->id);

        $comment->edit(new DateTimeImmutable(), $command->text);

        $this->flusher->flush();

        return $comment->getId()->getValue();
    }
}
