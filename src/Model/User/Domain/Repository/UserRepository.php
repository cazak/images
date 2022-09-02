<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Repository;

use App\Model\User\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

interface UserRepository
{
    public function add(User $entity, bool $flush = false): void;

    public function remove(User $entity, bool $flush = false): void;
}
