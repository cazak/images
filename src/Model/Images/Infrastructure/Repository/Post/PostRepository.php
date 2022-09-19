<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\Repository\Post;

use App\Model\Images\Domain\Entity\Post\Post;
use App\Model\Images\Domain\Repository\Post\PostRepository as PostRepositoryInterface;
use App\Model\Shared\Exceptions\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function add(Post $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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
}
