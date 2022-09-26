<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Comment\Command\Remove;

final class RemoveCommentCommand
{
    public string $commentId;
    public string $postId;
}
