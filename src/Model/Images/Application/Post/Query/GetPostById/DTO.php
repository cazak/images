<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Query\GetPostById;

final class DTO
{
    public function __construct(
        public string $id,
        public string $author_id,
        public string $date,
        public string $avatar,
        public string $author_avatar,
        public string $description,
        public string $nickname,
        public int $likesCount,
        public bool $isLiked,
        public int $commentsCount,
    ) {
    }

    public static function fromPost(array $post): self
    {
        return new self(
            $post['id'],
            $post['author_id'],
            $post['date'],
            $post['avatar'],
            $post['author_avatar'],
            $post['description'],
            $post['nickname'],
            $post['likesCount'],
            $post['isLiked'],
            $post['commentsCount'],
        );
    }
}
