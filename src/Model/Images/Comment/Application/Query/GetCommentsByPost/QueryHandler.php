<?php

declare(strict_types=1);

namespace App\Model\Images\Comment\Application\Query\GetCommentsByPost;

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
            ->select(['c.id AS id', 'c.text', 'c.date', 'c.update_date', 'a.nickname', 'a.avatar', 'a.id AS author_id'])
            ->from('images_comments', 'c')
            ->where('c.post_id = :postId')
            ->leftJoin('c', 'images_authors', 'a', 'c.author_id = a.id')
            ->setParameter('postId', $query->postId)
            ->orderBy('date', 'DESC')
            ->executeQuery()
            ->fetchAllAssociative();
    }
}
