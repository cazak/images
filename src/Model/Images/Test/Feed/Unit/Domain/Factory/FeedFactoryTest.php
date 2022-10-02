<?php

declare(strict_types=1);

namespace App\Model\Images\Test\Feed\Unit\Domain\Factory;

use App\Model\Images\Domain\Factory\Feed\FeedFactory;
use App\Model\Images\Test\Author\Builder\AuthorBuilder;
use App\Model\Images\Test\Post\Builder\PostBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class FeedFactoryTest extends TestCase
{
    public function test_success(): void
    {
        $factory = new FeedFactory();

        $date = new DateTimeImmutable();
        $reader = (new AuthorBuilder())->build();
        $author = (new AuthorBuilder())->viaAvatar()->build();
        $post = (new PostBuilder())->viaAuthor($author)->build();

        $feed = $factory->create($reader, $author, $post, $date);

        self::assertEquals($date, $feed->getDate());
        self::assertEquals($reader, $feed->getReader());
        self::assertEquals($author, $feed->getAuthor());
        self::assertEquals($post, $feed->getPost());

        self::assertEquals($feed->getAuthorData()->getName()->getName(), $author->getName()->getName());
        self::assertEquals($feed->getAuthorData()->getName()->getSurname(), $author->getName()->getSurname());
        self::assertEquals($feed->getAuthorData()->getNickname(), $author->getNickname());
        self::assertEquals($feed->getAuthorData()->getAvatar(), $author->getAvatar());

        self::assertEquals($feed->getPostData()->getDate(), $post->getDate());
        self::assertEquals($feed->getPostData()->getAvatar(), $post->getAvatar());
        self::assertEquals($feed->getPostData()->getDescription(), $post->getDescription());
    }

    public function test_wrong(): void
    {
        $factory = new FeedFactory();

        $reader = (new AuthorBuilder())->build();
        $author = (new AuthorBuilder())->build();
        $post = (new PostBuilder())->build();

        $this->expectExceptionMessage('Wrong post author.');
        $factory->create($reader, $author, $post);
    }
}
