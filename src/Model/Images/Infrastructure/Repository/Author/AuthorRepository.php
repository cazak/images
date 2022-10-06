<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\Repository\Author;

use App\Model\Images\Domain\Entity\Author\Author;
use App\Model\Images\Domain\Repository\Author\AuthorRepository as AuthorRepositoryInterface;
use App\Model\Shared\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

final class AuthorRepository extends ServiceEntityRepository implements AuthorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function add(Author $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Author $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @throws EntityNotFoundException
     */
    public function get(string $id): Author
    {
        $author = $this->findOneBy(['id' => $id]);

        if (!$author) {
            throw new EntityNotFoundException();
        }

        return $author;
    }

    /**
     * @return Author[]
     */
    public function findAllByIds(array $ids): array
    {
        return $this->findBy(['id' => $ids]);
    }

    public function findByEmail(string $email): ?Author
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function checkAuthorsExistForSubscribe(string $firstAuthorId, string $secondAuthorId): bool
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.id IN (:ids)')
            ->setParameter('ids', [$firstAuthorId, $secondAuthorId], Connection::PARAM_STR_ARRAY)
            ->getQuery()->getSingleScalarResult() >= 2;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function existByNickname(string $nickname): bool
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.nickname = :nickname')
            ->setParameter('nickname', $nickname)
            ->getQuery()
            ->getSingleScalarResult() >= 1;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function hasById(string $id): bool
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult() >= 1;
    }
}
