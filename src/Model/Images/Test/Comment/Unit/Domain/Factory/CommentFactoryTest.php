<?php

declare(strict_types=1);

namespace App\Model\Images\Test\Comment\Unit\Domain\Factory;

use App\Model\Images\Domain\Factory\Comment\CommentFactory;
use App\Model\Images\Test\Author\Builder\AuthorBuilder;
use App\Model\Images\Test\Post\Builder\PostBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class CommentFactoryTest extends TestCase
{
    public function test_success(): void
    {
        $post = (new PostBuilder())->build();
        $author = (new AuthorBuilder())->build();
        $text = 'Comment\'s text';

        $factory = new CommentFactory();

        $comment = $factory->create($post, $author, $text);

        self::assertEquals($author->getId()->getValue(), $comment->getAuthor()->getId()->getValue());
        self::assertEquals($post->getId()->getValue(), $comment->getPost()->getId()->getValue());
        self::assertEquals($text, $comment->getText());
        self::assertInstanceOf(DateTimeImmutable::class, $comment->getDate());
        self::assertNull($comment->getUpdateDate());
    }
}
