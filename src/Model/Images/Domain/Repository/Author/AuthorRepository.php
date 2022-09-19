<?php

namespace App\Model\Images\Domain\Repository\Author;

use App\Model\Images\Domain\Entity\Author\Author;

interface AuthorRepository
{
    public function add(Author $entity, bool $flush = true): void;

    public function remove(Author $entity, bool $flush = true): void;

    public function get(string $id): Author;

    public function checkAuthorsExistForSubscribe(string $firstAuthorId, string $secondAuthorId): bool;

    public function existByNickname(string $nickname): bool;
}
