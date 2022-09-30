<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Command\Remove;

final class RemovePostCommand
{
    public string $postId;
    public string $authorId;
}
