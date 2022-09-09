<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\FindUserByNicknameOrId;

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
        $user = $this->connection->createQueryBuilder()
            ->from('`user_users`')
            ->select(['nickname', 'id', 'name'])
            ->where('nickname = :nicknameOrId')
            ->orWhere('id = :nicknameOrId')
            ->andWhere('is_verified = TRUE')
            ->setParameter(':nicknameOrId', $query->nicknameOrId)
            ->fetchOne();

        return DTO::fromUser($user);
    }
}
