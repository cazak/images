<?php

namespace App\Model\Images\Domain\Repository\Comment;

use App\Model\Images\Domain\Entity\Comment\Comment;

interface CommentRepository
{
    public function add(Comment $entity): void;

    public function remove(Comment $entity, bool $flush = true): void;

    public function get(string $id): Comment;
}
