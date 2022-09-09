<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetUserByNicknameOrId;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class QueryHandler
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @throws Exception
     */
    public function fetch(Query $query): DTO
    {
        if (preg_match('/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/', $query->nicknameOrId)) {
            $result = $this->connection->createQueryBuilder()
                ->from('user_users')
                ->select(['nickname', 'id', 'name'])
                ->where('id = :id')
                ->andWhere('is_verified = TRUE')
                ->setParameter('id', $query->nicknameOrId)
                ->executeQuery();

            $row = $result->fetchAssociative();
        } else {
            $result = $this->connection->createQueryBuilder()
                ->from('user_users')
                ->select(['nickname', 'id', 'name'])
                ->where('name = :nickname')
                ->andWhere('is_verified = TRUE')
                ->setParameter('nickname', $query->nicknameOrId)
                ->executeQuery();

            $row = $result->fetchAssociative();
        }

        if (false !== $row) {
            return DTO::fromUser($row);
        }

        throw new \RuntimeException('User not found');
    }
}
