<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetMutualFriends;

use App\Model\User\Infrastructure\Repository\RedisUserRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RedisException;

final class GetMutualFriends
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
    public function fetch(string $currentUserId, string $forUserId): array
    {
        $mutualFiendIds = $this->redisUserRepository->getMutualFriends($currentUserId, $forUserId);

        return $this->connection->createQueryBuilder()
            ->from('user_users')
            ->select(['id', 'nickname', 'name_name AS name'])
            ->where('id IN (:ids)')
            ->setParameter('ids', $mutualFiendIds, Connection::PARAM_STR_ARRAY)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
