<?php

declare(strict_types=1);

namespace App\Model\Images\Comment\Application\Command\Remove;

final class RemoveCommentCommand
{
    public string $commentId;
    public string $postId;
}
