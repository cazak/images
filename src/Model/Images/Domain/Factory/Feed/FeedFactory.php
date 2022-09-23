<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Factory\Feed;

use App\Model\Images\Domain\Entity\Author\Author;
use App\Model\Images\Domain\Entity\Feed\Author as AuthorData;
use App\Model\Images\Domain\Entity\Feed\AuthorName;
use App\Model\Images\Domain\Entity\Feed\Feed;
use App\Model\Images\Domain\Entity\Feed\Post as PostData;
use App\Model\Images\Domain\Entity\Post\Post;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;
use DomainException;

final class FeedFactory
{
    public function create(Author $reader, Author $author, Post $post, DateTimeImmutable $date = new DateTimeImmutable()): Feed
    {
        if (!$post->getAuthor()->getId()->isEqual($author->getId())) {
            throw new DomainException('Wrong post author.');
        }

        return new Feed(
            Id::next(),
            $date,
            $reader,
            $post,
            new PostData(
                $post->getDate(),
                $post->getDescription(),
                $post->getAvatar()
            ),
            $author,
            new AuthorData(
                new AuthorName(
                    $author->getName()->getName(),
                    $author->getName()->getSurname()
                ),
                $author->getNickname(),
                $author->getAvatar()
            ),
        );
    }
}
