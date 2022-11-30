<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Test\Builder;

use App\Model\Images\Author\Domain\Entity\Author;
use App\Model\Images\Author\Domain\Entity\Name;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;

final class AuthorBuilder
{
    private Id $id;

    private DateTimeImmutable $date;

    private bool $isBlocked = false;

    private string $nickname;

    private Name $name;

    private ?string $avatar = null;

    public function __construct()
    {
        $this->id = Id::next();
        $this->date = new DateTimeImmutable();
        $this->nickname = 'nickname';
        $this->name = new Name('first', 'last');
    }

    public function blocked(): self
    {
        $clone = clone $this;
        $clone->isBlocked = true;

        return $clone;
    }

    public function viaAvatar(string $avatar = 'uploads/author/date/test.jpg'): self
    {
        $clone = clone $this;
        $clone->avatar = $avatar;

        return $clone;
    }

    public function build(): Author
    {
        $author = new Author($this->id, $this->date, $this->name, $this->nickname);

        if ($this->avatar) {
            $author->changeAvatar($this->avatar);
        }

        if ($this->isBlocked) {
            $author->block();
        }

        return $author;
    }
}
