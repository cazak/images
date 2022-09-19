<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Query\ShowAuthorProfile;

use App\Model\Shared\Exceptions\EntityNotFoundException;
use App\Model\Images\Application\Author\Query\GetMutualFriends\GetMutualFriends;
use App\Model\Images\Application\Author\Query\GetAuthorByNicknameOrId\Query as AuthorQuery;
use App\Model\Images\Application\Author\Query\GetAuthorByNicknameOrId\QueryHandler as AuthorQueryHandler;
use Doctrine\DBAL\Exception;
use RedisException;

final class QueryHandler
{
    public function __construct(private readonly AuthorQueryHandler $handler, private readonly GetMutualFriends $mutualFriends)
    {
    }

    /**
     * @throws EntityNotFoundException
     * @throws RedisException
     * @throws Exception
     */
    public function fetch(Query $query): DTO
    {
        $author = $this->handler->fetch(new AuthorQuery($query->nicknameOrId));
        $mutualFiends = $this->mutualFriends->fetch($query->currentAuthorId, $author->id);

        return new DTO($author, $mutualFiends);
    }
}
