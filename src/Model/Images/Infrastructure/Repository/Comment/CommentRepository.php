<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\Repository\Comment;

use App\Model\Images\Domain\Entity\Comment\Comment;
use App\Model\Images\Domain\Repository\Comment\CommentRepository as CommentRepositoryInterface;
use App\Model\Shared\Exceptions\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class CommentRepository extends ServiceEntityRepository implements CommentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function add(Comment $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    public function remove(Comment $entity): void
    {
        $this->getEntityManager()->remove($entity);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function get(string $id): Comment
    {
        $author = $this->findOneBy(['id' => $id]);

        if (!$author) {
            throw new EntityNotFoundException();
        }

        return $author;
    }

    /**
     * @return Comment[]
     */
    public function findAllByPost(string $id): array
    {
        return $this->findBy(['post' => $id]);
    }
}
