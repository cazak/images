<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Entity\Author;

use App\Model\Images\Infrastructure\Repository\Author\AuthorRepository;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[ORM\Table(name: '`images_authors`')]
class Author
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid_id')]
    private Id $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $date;

    #[ORM\Column(type: 'images_author_status')]
    private Status $status;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: false)]
    private string $nickname;

    #[ORM\Embedded(class: Name::class, columnPrefix: false)]
    private Name $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $avatar = null;

    public function __construct(Id $id, DateTimeImmutable $date, Name $name, string $nickname)
    {
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
        $this->nickname = $nickname;
        $this->status = Status::active();
    }

    public function activate(): void
    {
        if ($this->status->isActive()) {
            throw new DomainException('Author is already active');
        }

        $this->status = Status::active();
    }

    public function block(): void
    {
        if ($this->status->isBlocked()) {
            throw new DomainException('Author is already blocked');
        }

        $this->status = Status::blocked();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }
}
