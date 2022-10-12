<?php

namespace App\Model\Images\Domain\Repository\Feed;

use App\Model\Images\Domain\Entity\Feed\Feed;

interface FeedRepository
{
    public function add(Feed $entity): void;

    public function remove(Feed $entity): void;

    public function get(string $id): Feed;

    /**
     * @return Feed[]
     */
    public function findAllByPost(string $id): array;

    /**
     * @return Feed[]
     */
    public function findAllByAuthor(string $id): array;
}
