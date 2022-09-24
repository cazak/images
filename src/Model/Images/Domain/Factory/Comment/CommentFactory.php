<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Factory\Comment;

use App\Model\Images\Domain\Entity\Author\Author;
use App\Model\Images\Domain\Entity\Comment\Comment;
use App\Model\Images\Domain\Entity\Post\Post;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;

final class CommentFactory
{
    public function create(Post $post, Author $author, string $text): Comment
    {
        return new Comment(Id::next(), new DateTimeImmutable(), $post, $author, $text);
    }
}
