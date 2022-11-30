<?php

declare(strict_types=1);

namespace App\Model\Images\Test\Comment\Builder;

use App\Model\Images\Author\Domain\Entity\Author;
use App\Model\Images\Comment\Domain\Entity\Comment;
use App\Model\Images\Post\Domain\Entity\Post;
use App\Model\Images\Test\Author\Builder\AuthorBuilder;
use App\Model\Images\Test\Post\Builder\PostBuilder;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;

final class CommentBuilder
{
    private Id $id;

    private DateTimeImmutable $date;

    private ?DateTimeImmutable $updateDate = null;

    private Post $post;

    private Author $author;

    private string $text;

    public function __construct()
    {
        $this->id = Id::next();
        $this->author = (new AuthorBuilder())->build();
        $this->post = (new PostBuilder())->build();
        $this->date = new DateTimeImmutable();
        $this->text = 'Comment\'s text';
    }

    public function viaAuthor(Author $author): self
    {
        $clone = clone $this;
        $clone->author = $author;

        return $clone;
    }

    public function viaPost(Post $post): self
    {
        $clone = clone $this;
        $clone->post = $post;

        return $clone;
    }

    public function viaText(string $text): self
    {
        $clone = clone $this;
        $clone->text = $text;

        return $clone;
    }

    public function updated(DateTimeImmutable $date): self
    {
        $clone = clone $this;
        $clone->updateDate = $date;

        return $clone;
    }

    public function build(): Comment
    {
        $comment = new Comment($this->id, $this->date, $this->post, $this->author, $this->text);

        if ($this->updateDate) {
            $comment->edit($this->updateDate, $this->text);
        }

        return $comment;
    }
}
