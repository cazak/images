<?php

declare(strict_types=1);

namespace App\Model\User\Application\Command\UnSubscribe;

use App\Model\User\Domain\Repository\UserRepository;
use App\Model\User\Infrastructure\Repository\RedisUserRepository;
use InvalidArgumentException;
use RedisException;

final class UnSubscribeCommandHandler
{
    public function __construct(
        private readonly RedisUserRepository $redisUserRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @throws RedisException
     */
    public function handle(UnSubscribeCommand $command): void
    {
        if (!$this->userRepository->checkUsersExistForSubscribe($command->unSubscribingUserId, $command->unFollowingUserId)) {
            throw new InvalidArgumentException('Incorrect user id parameters.');
        }

        $this->redisUserRepository->unSubscribe($command->unSubscribingUserId, $command->unFollowingUserId);
    }
}
