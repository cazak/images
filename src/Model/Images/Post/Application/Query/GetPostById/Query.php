<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Application\Query\GetPostById;

final class Query
{
    public function __construct(public readonly string $postId, public readonly string $authorId)
    {
    }
}
