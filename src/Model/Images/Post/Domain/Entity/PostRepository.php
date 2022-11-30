<?php

namespace App\Model\Images\Post\Domain\Entity;

interface PostRepository
{
    public function add(Post $entity): void;

    public function remove(Post $entity): void;

    public function get(string $id): Post;

    /**
     * @return Post[]
     */
    public function findAllByAuthor(string $authorId): array;

    public function hasById(string $id): bool;
}
