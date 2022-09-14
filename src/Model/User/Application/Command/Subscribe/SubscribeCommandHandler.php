<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\Subscribe;

use App\Model\User\Domain\Repository\UserRepository;
use App\Model\User\Infrastructure\Repository\RedisUserRepository;
use InvalidArgumentException;
use RedisException;

final class SubscribeCommandHandler
{
    public function __construct(
        private readonly RedisUserRepository $redisUserRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function handle(SubscribeCommand $command): void
    {
        if (!$this->userRepository->checkUsersExistForSubscribe($command->subscribingUserId, $command->followingUserId)) {
            throw new InvalidArgumentException('Incorrect user id parameters.');
        }

        $this->redisUserRepository->subscribe($command->subscribingUserId, $command->followingUserId);
    }
}
