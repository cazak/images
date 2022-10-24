<?php

namespace App\Model\Images\Domain\Repository\Author;

use App\Model\Images\Domain\Entity\Author\Author;

interface AuthorRepository
{
    public function add(Author $entity, bool $flush = true): void;

    public function remove(Author $entity, bool $flush = true): void;

    public function get(string $id): Author;

    /**
     * @param array<int, string> $ids
     * @return Author[]
     */
    public function findAllByIds(array $ids): array;

    public function checkAuthorsExistForSubscribe(string $firstAuthorId, string $secondAuthorId): bool;

    public function existByNickname(string $nickname): bool;

    public function hasById(string $id): bool;
}
