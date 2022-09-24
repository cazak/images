<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Feed\Query\GetFeedByReader;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class QueryHandler
{
    public function __construct(private readonly Connection $connection, private readonly int $limit)
    {
    }

    /**
     * @throws Exception
     */
    public function fetch(Query $query): array
    {
        return $this->connection->createQueryBuilder()
            ->select([
                'author_nickname',
                'author_avatar',
                'post_date',
                'post_avatar',
                'post_description',
            ])
            ->from('images_feeds')
            ->where('reader_id = :id')
            ->setParameter('id', $query->readerId)
            ->orderBy('post_date', 'DESC')
            ->setFirstResult(0)
            ->setMaxResults($this->limit)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
