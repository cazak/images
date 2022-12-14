<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Domain\Entity;

use App\Model\Images\Author\Domain\Entity\Author;
use App\Model\Images\Post\Infrastructure\Repository\PostRepository;
use App\Model\Shared\Domain\Entity\AggregateRoot;
use App\Model\Shared\Domain\Entity\EventsTrait;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table(name: '`images_posts`')]
class Post implements AggregateRoot
{
    use EventsTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid_id')]
    private Id $id;

    #[ORM\ManyToOne(targetEntity: Author::class, cascade: ['persist'])]
    private Author $author;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $avatar;

    #[ORM\Column(type: 'text', nullable: false)]
    private string $description;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $date;

    public function __construct(Id $id, Author $author, string $avatar, string $description, DateTimeImmutable $date)
    {
        $this->id = $id;
        $this->author = $author;
        $this->avatar = $avatar;
        $this->description = $description;
        $this->date = $date;

        $this->recordEvent(
            new \App\Model\Images\Post\Domain\Entity\Event\PostCreated(
                $author->getId(),
                $this->id,
            )
        );
    }

    public function delete(Author $author): void
    {
        if (!$this->getAuthor()->getId()->isEqual($author->getId())) {
            throw new DomainException('Only the author can delete a post.');
        }

        $this->recordEvent(
            new \App\Model\Images\Post\Domain\Entity\Event\PostDeleted($this->id, $this->author->getId())
        );
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}
