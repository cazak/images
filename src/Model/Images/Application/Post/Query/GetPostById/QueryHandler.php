<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Query\GetPostById;

use App\Model\Images\Infrastructure\Repository\Post\RedisPostRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class QueryHandler
{
    public function __construct(
        private readonly Connection $connection,
        private readonly RedisPostRepository $redisPostRepository,
    ) {
    }

    /**
     * @throws Exception
     * @throws \RedisException
     */
    public function fetch(Query $query): DTO
    {
        $post = $this->connection->createQueryBuilder()
            ->from('images_posts', 'p')
            ->select(['p.id AS id', 'p.avatar AS avatar', 'p.description AS description', 'a.nickname AS nickname'])
            ->innerJoin('p', 'images_authors', 'a', 'p.author_id = a.id')
            ->where('p.id = :id')
            ->setParameter('id', $query->postId)
            ->executeQuery()
            ->fetchAssociative();

        $post['likesCount'] = $this->redisPostRepository->getLikesCount($query->postId);
        $post['isLiked'] = $this->redisPostRepository->isLiked($query->authorId, $query->postId);

        return DTO::fromPost($post);
    }
}