<?php

declare(strict_types=1);

namespace App\Model\Images\Feed\Application\Query\GetFeedByReader;

use App\Model\Images\Post\Infrastructure\Repository\RedisPostRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RedisException;

final class QueryHandler
{
    public function __construct(
        private readonly Connection $connection,
        private readonly RedisPostRepository $redisPostRepository,
        private readonly int $limit
    ) {
    }

    /**
     * @return array<int, array<string, bool|int|string>>
     *
     * @throws Exception
     * @throws RedisException
     */
    public function fetch(Query $query): array
    {
        $offset = ($query->page - 1) * $this->limit;

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
            ->setFirstResult($offset)
            ->setMaxResults($this->limit)
            ->executeQuery()
            ->fetchAllAssociative();

        foreach ($feedItems as &$feedItem) {
            $feedItem['likesCount'] = $this->redisPostRepository->getLikesCount($feedItem['post_id']);
            $feedItem['isLiked'] = $this->redisPostRepository->isLikedBy($query->readerId, $feedItem['post_id']);
            $feedItem['commentsCount'] = $this->redisPostRepository->getCommentsCount($feedItem['post_id']);
        }

        return $feedItems;
    }

    /**
     * @throws Exception
     */
    public function getFeedMaxPage(string $id): int
    {
        $count = $this->connection->createQueryBuilder()
            ->select('COUNT(id) AS count')
            ->from('images_feeds')
            ->where('reader_id = :id')
            ->setParameter('id', $id)
            ->executeQuery()->fetchOne();

        return (int) ceil($count / $this->limit);
    }
}
