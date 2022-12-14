<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Test\Builder;

use App\Model\Images\Author\Domain\Entity\Author;
use App\Model\Images\Author\Test\Builder\AuthorBuilder;
use App\Model\Images\Post\Domain\Entity\Post;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;

final class PostBuilder
{
    private Id $id;

    private ?Author $author = null;

    private string $avatar;

    private string $description;

    private DateTimeImmutable $date;

    public function __construct()
    {
        $this->id = Id::next();
        $this->date = new DateTimeImmutable();
        $this->description = 'description';
        $this->avatar = 'uploads/post/date/test.jpg';
    }

    public function viaAuthor(Author $author): self
    {
        $clone = clone $this;
        $clone->author = $author;

        return $clone;
    }

    public function build(): Post
    {
        if (null === $this->author) {
            $this->author = (new AuthorBuilder())->build();
        }

        return new Post($this->id, $this->author, $this->avatar, $this->description, $this->date);
    }
}
