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
    public function fetch(Filter $filter): array
    {
        $qb = $this->connection->createQueryBuilder()
            ->from('user_users')
            ->select([
                'TRIM(CONCAT(name_name, \' \', name_surname)) AS name',
                'nickname',
                'id',
                'status',
            ])
            ->where('is_verified = TRUE');

        if ($filter->name) {
            $qb->andWhere($qb->expr()->like('LOWER(CONCAT(name_name, \' \', name_surname))', ':name'));
            $qb->setParameter('name', '%'.mb_strtolower($filter->name).'%');
        }

        if ($filter->nickname) {
            $qb->andWhere($qb->expr()->like('LOWER(nickname)', ':nickname'));
            $qb->setParameter('nickname', '%'.mb_strtolower($filter->nickname).'%');
        }

        if ($filter->email) {
            $qb->andWhere($qb->expr()->like('LOWER(email)', ':email'));
            $qb->setParameter('email', '%'.mb_strtolower($filter->email).'%');
        }

        if ($filter->role) {
            $qb->andWhere($qb->expr()->like('LOWER(role)', ':role'));
            $qb->setParameter('role', '%'.mb_strtolower($filter->role).'%');
        }

        if ($filter->id) {
            $qb->andWhere('id = :id');
            $qb->setParameter('id', $filter->id);
        }

        $result = $qb->executeQuery();

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
