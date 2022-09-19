<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Query\GetPostById;

final class DTO
{
    public function __construct(public string $id, public string $avatar, public string $description, public string $nickname)
    {
    }

    public static function fromPost(array $post): self
    {
        return new self(
            $post['id'],
            $post['avatar'],
            $post['description'],
            $post['nickname'],
        );
    }
}
