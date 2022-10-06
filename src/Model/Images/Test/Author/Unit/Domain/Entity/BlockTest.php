<?php

declare(strict_types=1);

namespace App\Model\Images\Test\Author\Unit\Domain\Entity;

use App\Model\Images\Test\Author\Builder\AuthorBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class BlockTest extends TestCase
{
    public function test_success(): void
    {
        $author = (new AuthorBuilder())->build();

        self::assertTrue($author->getStatus()->isActive());
        self::assertFalse($author->getStatus()->isBlocked());

        $author->block();

        self::assertTrue($author->getStatus()->isBlocked());
        self::assertFalse($author->getStatus()->isActive());
    }

    public function test_already(): void
    {
        $author = (new AuthorBuilder())->blocked()->build();

        $this->expectExceptionMessage('Author is already blocked');
        $author->block();
    }
}
