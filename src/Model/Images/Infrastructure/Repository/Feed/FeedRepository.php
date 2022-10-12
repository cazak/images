<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\Repository\Feed;

use App\Model\Images\Domain\Entity\Feed\Feed;
use App\Model\Images\Domain\Repository\Feed\FeedRepository as FeedRepositoryInterface;
use App\Model\Shared\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class FeedRepository extends ServiceEntityRepository implements FeedRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feed::class);
    }

    public function add(Feed $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    public function remove(Feed $entity): void
    {
        $this->getEntityManager()->remove($entity);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function get(string $id): Feed
    {
        $author = $this->findOneBy(['id' => $id]);

        if (!$author) {
            throw new EntityNotFoundException();
        }

        return $author;
    }

    /**
     * @return Feed[]
     */
    public function findAllByPost(string $id): array
    {
        return $this->findBy(['post' => $id]);
    }

    /**
     * @return Feed[]
     */
    public function findAllByAuthor(string $id): array
    {
        return $this->findBy(['author' => $id]);
    }
}
