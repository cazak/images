<?php

declare(strict_types=1);

namespace App\Security;

use App\Model\User\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class GetUserForAuthenticateFetcher extends ServiceEntityRepository implements GetUserForAuthenticateFetcherInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function fetch(string $identifier): ?AuthUser
    {
        /** @var User $user */
        $user = $this->findOneBy([
            'email' => $identifier,
            'isVerified' => true,
        ]);

        return new AuthUser(
            $user->getId()->getValue(),
            $user->getName()->getName(),
            $user->getName()->getSurname(),
            $user->getRole(),
            $user->getEmail()->getValue(),
            $user->getPassword(),
        );
    }
}
