<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Infrastructure\Repository;

use Redis;
use RedisException;

final class RedisAuthorPostRepository
{
    private const ENTITY_KEY = 'author';
    private const POST_KEY = 'posts';

    public function __construct(private readonly Redis $redis)
    {
    }

    /**
     * @throws RedisException
     */
    public function increasePosts(string $authorId): void
    {
        $this->redis->incr(self::ENTITY_KEY.':'.$authorId.':'.self::POST_KEY);
    }

    /**
     * @throws RedisException
     */
    public function reducePosts(string $authorId): void
    {
        $this->redis->decr(self::ENTITY_KEY.':'.$authorId.':'.self::POST_KEY);
    }

    /**
     * @throws RedisException
     */
    public function getPostsCount(string $authorId): int
    {
        return (int) $this->redis->get(self::ENTITY_KEY.':'.$authorId.':'.self::POST_KEY);
    }
}
