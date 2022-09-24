<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\Repository\Feed;

use App\Model\Images\Domain\Entity\Feed\Feed;
use App\Model\Images\Domain\Repository\Feed\FeedRepository as FeedRepositoryInterface;
use App\Model\Shared\Exceptions\EntityNotFoundException;
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

    public function remove(Feed $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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
}
