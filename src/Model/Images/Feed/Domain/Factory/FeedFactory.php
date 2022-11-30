<?php

declare(strict_types=1);

namespace App\Model\Images\Feed\Domain\Factory;

use App\Model\Images\Author\Domain\Entity\Author;
use App\Model\Images\Domain\Entity\Post\Post;
use App\Model\Images\Feed\Domain\Entity\Author as AuthorData;
use App\Model\Images\Feed\Domain\Entity\AuthorName;
use App\Model\Images\Feed\Domain\Entity\Feed;
use App\Model\Images\Feed\Domain\Entity\Post as PostData;
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
