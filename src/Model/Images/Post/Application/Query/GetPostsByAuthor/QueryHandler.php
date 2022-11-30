<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Application\Query\GetPostsByAuthor;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class QueryHandler
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @return array<int, array<string, string>>
     *
     * @throws Exception
     */
    public function fetch(Query $query): array
    {
        return $this->connection->createQueryBuilder()
            ->select(['id', 'avatar', 'description', 'date'])
            ->from('images_posts')
            ->where('author_id = :author_id')
            ->setParameter('author_id', $query->authorId)
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
