<?php

namespace App\Model\Images\Feed\Domain\Entity;

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
