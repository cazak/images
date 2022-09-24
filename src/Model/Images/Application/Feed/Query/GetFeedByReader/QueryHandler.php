<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Feed\Query\GetFeedByReader;

use App\Model\Images\Infrastructure\Repository\Post\RedisPostRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class QueryHandler
{
    public function __construct(
        private readonly Connection $connection,
        private readonly RedisPostRepository $redisPostRepository,
        private readonly int $limit
    ) {
    }

    /**
     * @throws Exception
     * @throws \RedisException
     */
    public function fetch(Query $query): array
    {
        $feedItems = $this->connection->createQueryBuilder()
            ->select([
                'author_nickname',
                'author_avatar',
                'post_id',
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

        foreach ($feedItems as &$feedItem) {
            $feedItem['likesCount'] = $this->redisPostRepository->getLikesCount($feedItem['post_id']);
            $feedItem['isLiked'] = $this->redisPostRepository->isLikedBy($query->readerId, $feedItem['post_id']);
        }

        return $feedItems;
    }
}
