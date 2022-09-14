<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetUserByNicknameOrId;

use App\Model\Shared\Exceptions\EntityNotFoundException;
use App\Model\Shared\Service\UuidValidator;
use App\Model\User\Infrastructure\Repository\RedisUserRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use RedisException;
use RuntimeException;

final class QueryHandler
{
    public function __construct(
        private readonly Connection $connection,
        private readonly UuidValidator $uuidValidator,
        private readonly RedisUserRepository $userRepository
    ) {
    }

    /**
     * @throws Exception
     * @throws RedisException
     * @throws EntityNotFoundException
     */
    public function fetch(Query $query): DTO
    {
        $row = $this->getUser($query);
        if (!$row) {
            throw new EntityNotFoundException();
        }
        $row['subscriptions'] = $this->getSubscriptions($row['id']);
        $row['followers'] = $this->getFollowers($row['id']);
        $row['followersCount'] = (int)$this->userRepository->getFollowersCount($row['id']);
        $row['subscriptionsCount'] = (int)$this->userRepository->getSubscriptionsCount($row['id']);

        if (false !== $row) {
            return DTO::fromUser($row);
        }

        throw new RuntimeException('User not found');
    }

    /**
     * @throws Exception
     */
    private function getUser(Query $query): array|bool
    {
        if ($this->uuidValidator->validate($query->nicknameOrId)) {
            $result = $this->connection->createQueryBuilder()
                ->from('user_users')
                ->select(['nickname', 'id', 'name_name AS name', 'name_surname AS surname'])
                ->where('id = :id')
                ->andWhere('is_verified = TRUE')
                ->setParameter('id', $query->nicknameOrId)
                ->executeQuery();
        } else {
            $result = $this->connection->createQueryBuilder()
                ->from('user_users')
                ->select(['nickname', 'id', 'name_name AS name', 'name_surname AS surname'])
                ->where('nickname = :nickname')
                ->andWhere('is_verified = TRUE')
                ->setParameter('nickname', $query->nicknameOrId)
                ->executeQuery();
        }

        return $result->fetchAssociative();
    }

    /**
     * @throws RedisException
     * @throws Exception
     */
    private function getSubscriptions(string $userId): array
    {
        $subscriptions = $this->connection->createQueryBuilder()
            ->from('user_users')
            ->select(['nickname', 'id', 'name_name AS name', 'name_surname AS surname'])
            ->where('id IN (:ids)')
            ->setParameter('ids', $this->userRepository->getSubscriptions($userId), Connection::PARAM_STR_ARRAY)
            ->executeQuery()
            ->fetchAssociative();

        if (!$subscriptions) {
            return [];
        }

        return $subscriptions;
    }

    /**
     * @throws RedisException
     * @throws Exception
     */
    private function getFollowers(string $userId): array
    {
        $followers = $this->connection->createQueryBuilder()
            ->from('user_users')
            ->select(['nickname', 'id', 'name_name AS name', 'name_surname AS surname'])
            ->where('id IN (:ids)')
            ->setParameter('ids', $this->userRepository->getFollowers($userId), Connection::PARAM_STR_ARRAY)
            ->executeQuery()
            ->fetchAssociative();

        if (!$followers) {
            return [];
        }

        return $followers;
    }
}
