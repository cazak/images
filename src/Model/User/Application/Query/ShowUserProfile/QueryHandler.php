<?php

declare(strict_types=1);

namespace App\Model\User\Application\Query\ShowUserProfile;

use App\Model\Shared\Exceptions\EntityNotFoundException;
use App\Model\User\Application\Query\GetMutualFriends\GetMutualFriends;
use App\Model\User\Application\Query\GetUserByNicknameOrId\Query as UserQuery;
use App\Model\User\Application\Query\GetUserByNicknameOrId\QueryHandler as UserQueryHandler;
use Doctrine\DBAL\Exception;
use RedisException;

final class QueryHandler
{
    public function __construct(private readonly UserQueryHandler $handler, private readonly GetMutualFriends $mutualFriends)
    {
    }

    /**
     * @throws EntityNotFoundException
     * @throws RedisException
     * @throws Exception
     */
    public function fetch(Query $query): DTO
    {
        $user = $this->handler->fetch(new UserQuery($query->nicknameOrId));
        $mutualFiends = $this->mutualFriends->fetch($query->currentUserId, $user->id);

        return new DTO($user, $mutualFiends);
    }
}
