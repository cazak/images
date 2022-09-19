<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Query\GetMutualFriends;

use App\Model\Images\Infrastructure\Repository\Author\RedisAuthorRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RedisException;

final class GetMutualFriends
{
    public function __construct(
        private readonly Connection $connection,
        private readonly RedisAuthorRepository $redisAuthorRepository
    ) {
    }

    /**
     * @throws RedisException
     * @throws Exception
     */
    public function fetch(string $currentAuthorId, string $forAuthorId): array
    {
        $mutualFiendIds = $this->redisAuthorRepository->getMutualFriends($currentAuthorId, $forAuthorId);

        return $this->connection->createQueryBuilder()
            ->from('images_authors')
            ->select(['id', 'nickname', 'name'])
            ->where('id IN (:ids)')
            ->setParameter('ids', $mutualFiendIds, Connection::PARAM_STR_ARRAY)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
