<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetUsers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class QueryHandler
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @return DTO[]
     *
     * @throws Exception
     */
    public function fetch(): array
    {
        $result = $this->connection->createQueryBuilder()
            ->from('user_users')
            ->select(['name_name AS name', 'name_surname AS surname', 'nickname', 'id'])
            ->where('is_verified = TRUE')
            ->executeQuery();

        $rows = $result->fetchAllAssociative();

        $userDTOs = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $userDTOs[] = DTO::fromUser($row);
            }
        }

        return $userDTOs;
    }
}
