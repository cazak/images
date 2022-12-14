<?php

declare(strict_types=1);

namespace App\Model\User\Infrastructure\Repository;

use App\Model\Shared\Exception\EntityNotFoundException;
use App\Model\User\Domain\Entity\User;
use App\Model\User\Domain\Repository\UserRepository as UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws EntityNotFoundException
     */
    public function get(string $id): User
    {
        $user = $this->findOneBy(['id' => $id]);

        if (!$user) {
            throw new EntityNotFoundException();
        }

        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findByConfirmToken(string $token): ?User
    {
        return $this->findOneBy(['confirmToken' => $token]);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function checkUsersExistForSubscribe(string $firstUserId, string $secondUserId): bool
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.id IN (:ids)')
            ->setParameter('ids', [$firstUserId, $secondUserId], Connection::PARAM_STR_ARRAY)
            ->getQuery()->getSingleScalarResult() >= 2;
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
