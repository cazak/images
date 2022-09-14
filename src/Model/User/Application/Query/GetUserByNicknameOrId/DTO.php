<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\GetUserByNicknameOrId;

final class DTO
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $surname,
        public ?string $nickname,
        public array $subscriptions,
        public int $subscriptionsCount,
        public array $followers,
        public int $followersCount,
    ) {
    }

    public static function fromUser($user): self
    {
        return new self(
            $user['id'],
            $user['name'],
            $user['surname'],
            $user['nickname'],
            $user['subscriptions'],
            $user['subscriptionsCount'],
            $user['followers'],
            $user['followersCount'],
        );
    }
}
