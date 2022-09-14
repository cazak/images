<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetSubscriptions;

use RedisException;
use App\Model\User\Infrastructure\Repository\RedisUserRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class GetSubscriptions
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
        return $this->connection->createQueryBuilder()
            ->from('user_users')
            ->select(['nickname', 'id', 'name_name AS name', 'name_surname AS surname'])
            ->where('id IN (:ids)')
            ->setParameter('ids', $this->redisUserRepository->getSubscriptions($userId), Connection::PARAM_STR_ARRAY)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
