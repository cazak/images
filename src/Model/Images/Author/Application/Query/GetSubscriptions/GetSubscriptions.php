<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Query\GetSubscriptions;

use App\Model\Images\Author\Infrastructure\Repository\RedisAuthorRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RedisException;

final class GetSubscriptions
{
    public function __construct(
        private readonly Connection $connection,
        private readonly RedisAuthorRepository $redisAuthorRepository
    ) {
    }

    /**
     * @return array<int, array<string, string>>
     *
     * @throws RedisException
     * @throws Exception
     */
    public function fetch(string $AuthorId): array
    {
        $subscriptionIds = $this->redisAuthorRepository->getSubscriptions($AuthorId);

        return $this->connection->createQueryBuilder()
            ->from('images_authors')
            ->select(['nickname', 'id', 'name', 'surname'])
            ->where('id IN (:ids)')
            ->setParameter('ids', $subscriptionIds, Connection::PARAM_STR_ARRAY)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
