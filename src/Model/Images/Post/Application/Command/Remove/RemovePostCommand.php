<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Application\Command\Remove;

final class RemovePostCommand
{
    public string $postId;
    public string $authorId;
}
