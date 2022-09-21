<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\Repository\Post;

use Redis;
use RedisException;

final class RedisPostRepository
{
    private const ENTITY_KEY = 'post';
    private const ACTOR_KEY = 'author';
    private const LIKE_KEY = 'likes';

    public function __construct(private readonly Redis $redis)
    {
    }

    /**
     * @throws RedisException
     */
    public function like(string $authorId, string $postId): void
    {
        $this->redis->sAdd(self::ENTITY_KEY . ':' . $postId . ':' . self::LIKE_KEY, $authorId);
        $this->redis->sAdd(self::ACTOR_KEY . ':' . $authorId . ':' . self::LIKE_KEY, $postId);
    }

    /**
     * @throws RedisException
     */
    public function unlike(string $authorId, string $postId): void
    {
        $this->redis->sRem(self::ENTITY_KEY . ':' . $postId . ':' . self::LIKE_KEY, $authorId);
        $this->redis->sRem(self::ACTOR_KEY . ':' . $authorId . ':' . self::LIKE_KEY, $postId);
    }

    /**
     * @throws RedisException
     */
    public function isLiked(string $authorId, string $postId): bool
    {
        return $this->redis->sIsMember(self::ENTITY_KEY . ':' . $postId . ':' . self::LIKE_KEY, $authorId);
    }

    /**
     * @throws RedisException
     */
    public function getLikesCount(string $postId): Redis|int
    {
        return $this->redis->sCard(self::ENTITY_KEY . ':' . $postId . ':' . self::LIKE_KEY);
    }
}
