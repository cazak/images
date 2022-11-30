<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Query\ShowAuthorProfile;

use App\Model\Images\Author\Application\Query\GetAuthorByNicknameOrId\DTO as AuthorDTO;

final class DTO
{
    /**
     * @param array<int, array<string, string>> $mutualFriends
     */
    public function __construct(
        public readonly AuthorDTO $author,
        public readonly array $mutualFriends,
        public readonly bool $isSubscribed,
    ) {
    }
}
