<?php

namespace App\Model\Images\Domain\Repository\Post;

use App\Model\Images\Domain\Entity\Post\Post;

interface PostRepository
{
    public function add(Post $entity, bool $flush = true): void;

    public function remove(Post $entity, bool $flush = true): void;

    public function get(string $id): Post;

    public function hasById(string $id): bool;
}
