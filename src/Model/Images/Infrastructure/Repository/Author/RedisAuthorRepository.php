<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\Repository\Author;

use Redis;
use RedisException;

final class RedisAuthorRepository
{
    private const ENTITY_KEY = 'author';
    private const FOLLOW_KEY = 'followers';
    private const SUBSCRIBE_KEY = 'subscriptions';

    public function __construct(private readonly Redis $redis)
    {
    }

    /**
     * @throws RedisException
     */
    public function subscribe($subscribingAuthorId, $followingAuthorId): void
    {
        // add subscriptions
        $this->redis->sAdd(self::ENTITY_KEY . ':' . $subscribingAuthorId . ':' . self::SUBSCRIBE_KEY, $followingAuthorId);

        // add followers
        $this->redis->sAdd(self::ENTITY_KEY . ':' . $followingAuthorId . ':' . self::FOLLOW_KEY, $subscribingAuthorId);
    }

    /**
     * @throws RedisException
     */
    public function unSubscribe($unSubscribingAuthorId, $unFollowingAuthorId): void
    {
        // remove subscriptions
        $this->redis->sRem(self::ENTITY_KEY . ':' . $unSubscribingAuthorId . ':' . self::SUBSCRIBE_KEY, $unFollowingAuthorId);

        // remove followers
        $this->redis->sRem(self::ENTITY_KEY . ':' . $unFollowingAuthorId . ':' . self::FOLLOW_KEY, $unSubscribingAuthorId);
    }

    /**
     * @throws RedisException
     */
    public function getMutualFriends(string $currentAuthorId, string $forAuthorId): bool|array|Redis
    {
        return $this->redis->sInter(
            self::ENTITY_KEY . ':' . $currentAuthorId . ':' . self::SUBSCRIBE_KEY,
            self::ENTITY_KEY . ':' . $forAuthorId . ':' . self::FOLLOW_KEY
        );
    }

    /**
     * @throws RedisException
     */
    public function getSubscriptions($authorId): Redis|array
    {
        return $this->redis->sMembers(self::ENTITY_KEY . ':' . $authorId . ':' . self::SUBSCRIBE_KEY);
    }

    /**
     * @throws RedisException
     */
    public function getSubscriptionsCount($authorId): Redis|int
    {
        return $this->redis->sCard(self::ENTITY_KEY . ':' . $authorId . ':' . self::SUBSCRIBE_KEY);
    }

    /**
     * @throws RedisException
     */
    public function getFollowers($authorId): Redis|array
    {
        return $this->redis->sMembers(self::ENTITY_KEY . ':' . $authorId . ':' . self::FOLLOW_KEY);
    }

    /**
     * @throws RedisException
     */
    public function getFollowersCount($authorId): Redis|int
    {
        return $this->redis->sCard(self::ENTITY_KEY . ':' . $authorId . ':' . self::FOLLOW_KEY);
    }

    /**
     * @throws RedisException
     */
    public function isSubscribed(string $currentAuthorId, string $forAuthorId): bool
    {
        return $this->redis->sIsMember(self::ENTITY_KEY . ':' . $currentAuthorId . ':' . self::SUBSCRIBE_KEY, $forAuthorId);
    }
}
