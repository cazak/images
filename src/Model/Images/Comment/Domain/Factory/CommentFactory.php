<?php

declare(strict_types=1);

namespace App\Model\Images\Comment\Domain\Factory;

use App\Model\Images\Author\Domain\Entity\Author;
use App\Model\Images\Comment\Domain\Entity\Comment;
use App\Model\Images\Post\Domain\Entity\Post;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;

final class CommentFactory
{
    public function create(Post $post, Author $author, string $text): Comment
    {
        return new Comment(Id::next(), new DateTimeImmutable(), $post, $author, $text);
    }
}
