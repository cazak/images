<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Domain\Factory;

use App\Model\Images\Author\Domain\Entity\Author;
use App\Model\Images\Author\Domain\Entity\Name;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;

final class AuthorFactory
{
    public function create(string $id, string $name, string $surname, string $nickname, ?DateTimeImmutable $date = null): Author
    {
        return new Author(new Id($id), $date ?: new DateTimeImmutable(), new Name($name, $surname), $nickname);
    }
}
