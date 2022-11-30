<?php

namespace App\Model\Images\Comment\Domain\Entity;

interface CommentRepository
{
    public function add(Comment $entity): void;

    public function remove(Comment $entity): void;

    public function get(string $id): Comment;

    /**
     * @return Comment[]
     */
    public function findAllByPost(string $id): array;
}
