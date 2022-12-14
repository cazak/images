<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Application\Query\ShowAuthorProfile;

use App\Model\Images\Author\Application\Query\GetAuthorByNicknameOrId\Query as AuthorQuery;
use App\Model\Images\Author\Application\Query\GetAuthorByNicknameOrId\QueryHandler as AuthorQueryHandler;
use App\Model\Images\Author\Application\Query\GetMutualFriends\GetMutualFriends;
use App\Model\Images\Author\Infrastructure\Repository\RedisAuthorRepository;
use App\Model\Shared\Exception\EntityNotFoundException;
use Doctrine\DBAL\Exception;
use RedisException;

final class QueryHandler
{
    public function __construct(
        private readonly AuthorQueryHandler $handler,
        private readonly GetMutualFriends $mutualFriends,
        private readonly RedisAuthorRepository $redisAuthorRepository
    ) {
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
        $isSubscribed = $this->redisAuthorRepository->isSubscribed($query->currentAuthorId, $author->id);

        return new DTO($author, $mutualFiends, $isSubscribed);
    }
}
