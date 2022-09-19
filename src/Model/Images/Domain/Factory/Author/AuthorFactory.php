<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Factory\Author;

use App\Model\Images\Domain\Entity\Author\Author;
use App\Model\Images\Domain\Entity\Author\Name;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;

final class AuthorFactory
{
    public function create(string $id, string $name, string $surname, string $nickname): Author
    {
        return new Author(new Id($id), new DateTimeImmutable(), new Name($name, $surname), $nickname);
    }
}
