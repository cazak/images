<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Entity\Comment;

use App\Model\Images\Domain\Entity\Author\Author;
use App\Model\Images\Domain\Entity\Post\Post;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'images_comments')]
#[ORM\Index(columns: ['date'])]
class Comment
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid_id')]
    private Id $id;

    #[ORM\Column(type: 'date_immutable')]
    private DateTimeImmutable $date;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?DateTimeImmutable $updateDate = null;

    #[ORM\ManyToOne(targetEntity: Post::class)]
    private Post $post;

    #[ORM\ManyToOne(targetEntity: Author::class)]
    private Author $author;

    #[ORM\Column(type: 'text')]
    private string $text;

    public function __construct(Id $id, DateTimeImmutable $date, Post $post, Author $author, string $text)
    {
        $this->id = $id;
        $this->date = $date;
        $this->post = $post;
        $this->author = $author;
        $this->text = $text;
    }

    public function edit(DateTimeImmutable $date, string $text): void
    {
        $this->updateDate = $date;
        $this->text = $text;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getUpdateDate(): ?DateTimeImmutable
    {
        return $this->updateDate;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
