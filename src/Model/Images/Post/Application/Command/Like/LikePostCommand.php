<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Application\Command\Like;

use App\Model\Shared\Service\UuidValidator;

final class LikePostCommand
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
