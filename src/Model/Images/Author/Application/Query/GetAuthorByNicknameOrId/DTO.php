<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Query\GetAuthorByNicknameOrId;

final class DTO
{
    /**
     * @param array<int, array<string, string>> $subscriptions
     * @param array<int, array<string, string>> $followers
     */
    public function __construct(
        public string $id,
        public string $name,
        public ?string $surname,
        public ?string $nickname,
        public ?string $avatar,
        public ?string $about,
        public array $subscriptions,
        public int $subscriptionsCount,
        public array $followers,
        public int $followersCount,
        public int $postsCount,
    ) {
    }

    /**
     * @param array<string, mixed> $author
     */
    public static function fromAuthor(array $author): self
    {
        return new self(
            $author['id'],
            $author['name'],
            $author['surname'],
            $author['nickname'],
            $author['avatar'],
            $author['about'],
            $author['subscriptions'],
            $author['subscriptionsCount'],
            $author['followers'],
            $author['followersCount'],
            $author['postsCount'],
        );
    }
}
