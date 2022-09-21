<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Command\Unlike;

use App\Model\Shared\Service\UuidValidator;

final class UnlikePostCommand
{
    public readonly string $authorId;
    public readonly string $postId;

    public function __construct(string $authorId, string $postId)
    {
        $validator = new UuidValidator();

        if ($validator->validate($authorId) && $validator->validate($postId)) {
            $this->authorId = $authorId;
            $this->postId = $postId;
        }
    }
}
