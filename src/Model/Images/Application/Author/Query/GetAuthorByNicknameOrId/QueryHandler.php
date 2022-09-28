<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Query\GetAuthorByNicknameOrId;

use App\Model\Images\Infrastructure\Repository\Author\RedisAuthorPostRepository;
use App\Model\Images\Application\Author\Query\GetFollowers\GetFollowers;
use App\Model\Images\Application\Author\Query\GetSubscriptions\GetSubscriptions;
use App\Model\Images\Infrastructure\Repository\Author\RedisAuthorRepository;
use App\Model\Shared\Exceptions\EntityNotFoundException;
use App\Model\Shared\Service\UuidValidator;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RedisException;

final class QueryHandler
{
    public function __construct(
        private readonly Connection $connection,
        private readonly UuidValidator $uuidValidator,
        private readonly RedisAuthorRepository $authorRepository,
        private readonly RedisAuthorPostRepository $redisAuthorPostRepository,
        private readonly GetSubscriptions $getSubscriptions,
        private readonly GetFollowers $getFollowers,
    ) {
    }

    /**
     * @throws Exception
     * @throws RedisException
     * @throws EntityNotFoundException
     */
    public function fetch(Query $query): DTO
    {
        $row = $this->getAuthor($query);

        $row['subscriptions'] = $this->getSubscriptions->fetch($row['id']);
        $row['followers'] = $this->getFollowers->fetch($row['id']);
        $row['followersCount'] = (int)$this->authorRepository->getFollowersCount($row['id']);
        $row['subscriptionsCount'] = (int)$this->authorRepository->getSubscriptionsCount($row['id']);
        $row['postsCount'] = $this->redisAuthorPostRepository->getPostsCount($row['id']);

        if (false !== $row) {
            return DTO::fromAuthor($row);
        }

        throw new EntityNotFoundException();
    }

    /**
     * @throws Exception
     */
    private function getAuthor(Query $query): array|bool
    {
        if ($this->uuidValidator->validate($query->nicknameOrId)) {
            $result = $this->connection->createQueryBuilder()
                ->from('images_authors')
                ->select(['nickname', 'id', 'name', 'surname', 'avatar'])
                ->where('id = :id')
                ->setParameter('id', $query->nicknameOrId)
                ->executeQuery();
        } else {
            $result = $this->connection->createQueryBuilder()
                ->from('images_authors')
                ->select(['nickname', 'id', 'name', 'surname', 'avatar'])
                ->where('nickname = :nickname')
                ->setParameter('nickname', $query->nicknameOrId)
                ->executeQuery();
        }

        return $result->fetchAssociative();
    }
}
