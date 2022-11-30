<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Infrastructure\Repository;

use App\Model\Images\Post\Domain\Entity\Post;
use App\Model\Images\Post\Domain\Entity\PostRepository as PostRepositoryInterface;
use App\Model\Shared\Exception\EntityNotFoundException;
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
        $post = $this->findOneBy(['id' => $id]);

        if (!$post) {
            throw new EntityNotFoundException();
        }

        return $post;
    }

    /**
     * @return Post[]
     */
    public function findAllByAuthor(string $authorId): array
    {
        return $this->findBy(['author' => $authorId]);
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
