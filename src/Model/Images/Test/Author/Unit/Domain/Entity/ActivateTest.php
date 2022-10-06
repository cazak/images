<?php

declare(strict_types=1);

namespace App\Model\Images\Test\Author\Unit\Domain\Entity;

use App\Model\Images\Test\Author\Builder\AuthorBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ActivateTest extends TestCase
{
    public function test_success(): void
    {
        $author = (new AuthorBuilder())->blocked()->build();

        self::assertTrue($author->getStatus()->isBlocked());
        self::assertFalse($author->getStatus()->isActive());

        $author->activate();

        self::assertTrue($author->getStatus()->isActive());
        self::assertFalse($author->getStatus()->isBlocked());
    }

    public function test_already(): void
    {
        $author = (new AuthorBuilder())->build();

        $this->expectExceptionMessage('Author is already active');
        $author->activate();
    }
}
