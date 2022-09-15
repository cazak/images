<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\ShowUserProfile;

use App\Model\User\Application\Query\GetUserByNicknameOrId\DTO as UserDTO;

final class DTO
{
    public function __construct(public readonly UserDTO $user, public readonly array $mutualFriends)
    {
    }
}
