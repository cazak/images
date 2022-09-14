<?php

declare(strict_types=1);

namespace App\Model\User\Infrastructure\Repository;

use Redis;
use RedisException;

final class RedisUserRepository
{
    private const ENTITY_KEY = 'user';
    private const FOLLOW_KEY = 'followers';
    private const SUBSCRIBE_KEY = 'subscriptions';

    public function __construct(private readonly Redis $redis)
    {
    }

    /**
     * @throws RedisException
     */
    public function subscribe($subscribingUserId, $followingUserId): void
    {
        // add subscriptions
        $this->redis->sAdd(self::ENTITY_KEY . ':' . $subscribingUserId . ':' . self::SUBSCRIBE_KEY, $followingUserId);

        // add followers
        $this->redis->sAdd(self::ENTITY_KEY . ':' . $followingUserId . ':' . self::FOLLOW_KEY, $subscribingUserId);
    }

    /**
     * @throws RedisException
     */
    public function unSubscribe($unSubscribingUserId, $unFollowingUserId): void
    {
        // remove subscriptions
        $this->redis->sRem(self::ENTITY_KEY . ':' . $unSubscribingUserId . ':' . self::SUBSCRIBE_KEY, $unFollowingUserId);

        // remove followers
        $this->redis->sRem(self::ENTITY_KEY . ':' . $unFollowingUserId . ':' . self::FOLLOW_KEY, $unSubscribingUserId);
    }

    /**
     * @throws RedisException
     */
    public function getSubscriptions($userId): Redis|array
    {
        return $this->redis->sMembers(self::ENTITY_KEY . ':' . $userId . ':' . self::SUBSCRIBE_KEY);
    }

    /**
     * @throws RedisException
     */
    public function getSubscriptionsCount($userId): Redis|int
    {
        return $this->redis->sCard(self::ENTITY_KEY . ':' . $userId . ':' . self::SUBSCRIBE_KEY);
    }

    /**
     * @throws RedisException
     */
    public function getFollowers($userId): Redis|array
    {
        return $this->redis->sMembers(self::ENTITY_KEY . ':' . $userId . ':' . self::FOLLOW_KEY);
    }

    /**
     * @throws RedisException
     */
    public function getFollowersCount($userId): Redis|int
    {
        return $this->redis->sCard(self::ENTITY_KEY . ':' . $userId . ':' . self::FOLLOW_KEY);
    }
}
