<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Query\GetFollowers;

use App\Model\Images\Infrastructure\Repository\Author\RedisAuthorRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RedisException;

final class GetFollowers
{
    public function __construct(
        private readonly Connection $connection,
        private readonly RedisAuthorRepository $redisAuthorRepository
    ) {
    }

    /**
     * @return array<int, array<string, string>>
     * @throws RedisException
     * @throws Exception
     */
    public function fetch(string $authorId): array
    {
        $followerIds = $this->redisAuthorRepository->getFollowers($authorId);

        return $this->connection->createQueryBuilder()
            ->from('images_authors')
            ->select(['nickname', 'id', 'name', 'surname'])
            ->where('id IN (:ids)')
            ->setParameter('ids', $followerIds, Connection::PARAM_STR_ARRAY)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
