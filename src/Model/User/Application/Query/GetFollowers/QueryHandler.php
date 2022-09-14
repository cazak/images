<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetFollowers;

use App\Model\User\Infrastructure\Repository\RedisUserRepository;
use RedisException;

final class QueryHandler
{
    public function __construct(private readonly RedisUserRepository $redisUserRepository)
    {
    }

    /**
     * @throws RedisException
     */
    public function fetch(Query $query)
    {
        return $this->redisUserRepository->getFollowers($query->userId);
    }
}
