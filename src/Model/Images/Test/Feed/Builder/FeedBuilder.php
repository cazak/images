<?php

declare(strict_types=1);

namespace App\Model\Images\Test\Feed\Builder;

use App\Model\Images\Domain\Entity\Author\Author as AuthorEntity;
use App\Model\Images\Domain\Entity\Post\Post as PostEntity;
use App\Model\Images\Feed\Domain\Entity\Author;
use App\Model\Images\Feed\Domain\Entity\AuthorName;
use App\Model\Images\Feed\Domain\Entity\Feed;
use App\Model\Images\Feed\Domain\Entity\Post;
use App\Model\Images\Test\Author\Builder\AuthorBuilder;
use App\Model\Images\Test\Post\Builder\PostBuilder;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;
use DomainException;

final class FeedBuilder
{
    private Id $id;

    private AuthorEntity $reader;

    private DateTimeImmutable $date;

    private PostEntity $post;

    private Post $postData;

    private AuthorEntity $author;

    private Author $authorData;

    public function __construct()
    {
        $authorBuilder = new AuthorBuilder();

        $this->id = Id::next();
        $this->date = new DateTimeImmutable();
        $this->reader = $authorBuilder->build();
        $this->author = $authorBuilder->build();
        $this->post = (new PostBuilder())->build();

        $this->authorData = new Author(
            new AuthorName(
                $this->author->getName()->getName(),
                $this->author->getName()->getSurname()
            ),
            $this->author->getNickname(),
            $this->author->getAvatar(),
        );

        $this->postData = new Post(
            $this->post->getDate(),
            $this->post->getDescription(),
            $this->post->getAvatar()
        );
    }

    public function viaReader(AuthorEntity $reader): self
    {
        $clone = clone $this;
        $clone->reader = $reader;

        return $clone;
    }

    public function viaAuthor(AuthorEntity $author): self
    {
        $clone = clone $this;
        $clone->author = $author;
        $this->authorData = new Author(
            new AuthorName(
                $clone->author->getName()->getName(),
                $clone->author->getName()->getSurname()
            ),
            $clone->author->getNickname(),
            $clone->author->getAvatar(),
        );

        return $clone;
    }

    public function viaPost(PostEntity $post): self
    {
        $clone = clone $this;
        $clone->post = $post;
        $this->postData = new Post(
            $clone->post->getDate(),
            $clone->post->getDescription(),
            $clone->post->getAvatar()
        );

        return $clone;
    }

    public function build(): Feed
    {
        if (!$this->post->getAuthor()->getId()->isEqual($this->author->getId())) {
            throw new DomainException('Wrong post author.');
        }

        return new Feed($this->id, $this->date, $this->reader, $this->post, $this->postData, $this->author, $this->authorData);
    }
}
