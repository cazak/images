<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Domain\Factory;

use App\Model\Images\Author\Domain\Entity\Author;
use App\Model\Images\Post\Domain\Entity\Post;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;

final class PostFactory
{
    public function create(
        Author $author,
        string $avatar,
        string $description,
        ?string $id = null,
        ?DateTimeImmutable $date = null,
    ): Post {
        return new Post(
            $id ? new Id($id) : Id::next(),
            $author,
            $avatar,
            $description,
            $date ?: new DateTimeImmutable(),
        );
    }
}
