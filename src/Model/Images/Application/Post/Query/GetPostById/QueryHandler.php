<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Query\GetPostById;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class QueryHandler
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    /**
     * @throws Exception
     */
    public function fetch(Query $query): DTO
    {
        $post = $this->connection->createQueryBuilder()
            ->from('images_posts', 'p')
            ->select(['p.id AS id', 'p.avatar AS avatar', 'p.description AS description', 'a.nickname AS nickname'])
            ->innerJoin('p', 'images_authors', 'a', 'p.author_id = a.id')
            ->where('p.id = :id')
            ->setParameter('id', $query->id)
            ->executeQuery()
            ->fetchAssociative();

        return DTO::fromPost($post);
    }
}
