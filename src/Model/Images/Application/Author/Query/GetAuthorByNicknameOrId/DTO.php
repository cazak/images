<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Query\GetAuthorByNicknameOrId;

final class DTO
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $surname,
        public ?string $nickname,
        public ?string $avatar,
        public array $subscriptions,
        public int $subscriptionsCount,
        public array $followers,
        public int $followersCount,
        public int $postsCount,
    ) {
    }

    public static function fromAuthor($author): self
    {
        return new self(
            $author['id'],
            $author['name'],
            $author['surname'],
            $author['nickname'],
            $author['avatar'],
            $author['subscriptions'],
            $author['subscriptionsCount'],
            $author['followers'],
            $author['followersCount'],
            $author['postsCount'],
        );
    }
}
