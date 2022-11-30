<?php

declare(strict_types=1);

namespace App\Model\Images\Comment\Test\Unit\Application\Edit;

use App\Model\Images\Comment\Test\Builder\CommentBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class EditCommentTest extends TestCase
{
    public function test_success(): void
    {
        $comment = (new CommentBuilder())->build();
        $date = new DateTimeImmutable();
        $text = 'New comment\'s text';

        self::assertNull($comment->getUpdateDate());
        self::assertNotNull($comment->getDate());

        $comment->edit($date, $text);

        self::assertEquals($date, $comment->getUpdateDate());
        self::assertEquals($text, $comment->getText());
    }
}
