<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Comment\Query\GetCommentsByPost;

final class Query
{
    public function __construct(public readonly string $postId)
    {
    }
}
