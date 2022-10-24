<?php

namespace App\Model\Images\Domain\Repository\Comment;

use App\Model\Images\Domain\Entity\Comment\Comment;

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
