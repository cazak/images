<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Query\GetPostsByAuthor;

final class Query
{
    public function __construct(public readonly string $authorId)
    {
    }
}
