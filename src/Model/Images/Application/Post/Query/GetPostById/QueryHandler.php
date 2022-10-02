<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Query\GetPostById;

use App\Model\Images\Infrastructure\Repository\Post\RedisPostRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RedisException;

final class QueryHandler
{
    public function __construct(
        private readonly Connection $connection,
        private readonly RedisPostRepository $redisPostRepository,
    ) {
    }

    /**
     * @throws Exception
     * @throws RedisException
     */
    public function fetch(Query $query): DTO
    {
        $post = $this->connection->createQueryBuilder()
            ->from('images_posts', 'p')
            ->select(['p.id AS id', 'p.date AS date', 'p.avatar AS avatar', 'p.description AS description', 'a.id AS author_id', 'a.nickname AS nickname', 'a.avatar AS author_avatar'])
            ->innerJoin('p', 'images_authors', 'a', 'p.author_id = a.id')
            ->where('p.id = :id')
            ->setParameter('id', $query->postId)
            ->executeQuery()
            ->fetchAssociative();

        $post['likesCount'] = $this->redisPostRepository->getLikesCount($query->postId);
        $post['isLiked'] = $this->redisPostRepository->isLikedBy($query->authorId, $query->postId);
        $post['commentsCount'] = $this->redisPostRepository->getCommentsCount($query->postId);

        return DTO::fromPost($post);
    }
}
