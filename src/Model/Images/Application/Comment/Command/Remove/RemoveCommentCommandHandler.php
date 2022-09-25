<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Comment\Command\Remove;

use App\Model\Images\Domain\Repository\Comment\CommentRepository;

final class RemoveCommentCommandHandler
{
    public function __construct(private readonly CommentRepository $repository)
    {
    }

    public function handle(RemoveCommentCommand $command): void
    {
        $comment = $this->repository->get($command->commentId);

        $this->repository->remove($comment);
    }
}
