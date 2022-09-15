<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetFollowers;

use App\Model\User\Infrastructure\Repository\RedisUserRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RedisException;

final class GetFollowers
{
    public function __construct(
        private readonly Connection $connection,
        private readonly RedisUserRepository $redisUserRepository
    ) {
    }

    /**
     * @throws RedisException
     * @throws Exception
     */
    public function fetch(string $userId): array
    {
        $followerIds = $this->redisUserRepository->getFollowers($userId);

        return $this->connection->createQueryBuilder()
            ->from('user_users')
            ->select(['nickname', 'id', 'name', 'surname'])
            ->where('id IN (:ids)')
            ->setParameter('ids', $followerIds, Connection::PARAM_STR_ARRAY)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
