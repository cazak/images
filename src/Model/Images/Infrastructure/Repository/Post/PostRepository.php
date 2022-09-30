<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\Repository\Post;

use App\Model\Images\Domain\Entity\Post\Post;
use App\Model\Images\Domain\Repository\Post\PostRepository as PostRepositoryInterface;
use App\Model\Shared\Exceptions\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

final class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function add(Post $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    public function remove(Post $entity): void
    {
        $this->getEntityManager()->remove($entity);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function get(string $id): Post
    {
        $author = $this->findOneBy(['id' => $id]);

        if (!$author) {
            throw new EntityNotFoundException();
        }

        return $author;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function hasById(string $id): bool
    {
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult() >= 1;
    }
}
