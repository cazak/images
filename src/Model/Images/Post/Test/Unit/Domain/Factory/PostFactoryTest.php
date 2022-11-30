<?php

declare(strict_types=1);

namespace App\Model\Images\Post\Test\Unit\Domain\Factory;

use App\Model\Images\Author\Test\Builder\AuthorBuilder;
use App\Model\Images\Post\Domain\Entity\Post;
use App\Model\Images\Post\Domain\Factory\PostFactory;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class PostFactoryTest extends TestCase
{
    public function test_success(): void
    {
        $factory = new PostFactory();

        $description = 'Post\'s description';
        $avatar = 'uploads/post/2022-09-19/1024px-Ivan-Kramskoy-Hristos-v-pustyne-Google-Art-Project-63288ef21906e.jpg';
        $author = (new AuthorBuilder())->build();

        /** @var Post $post */
        $post = $factory->create($author, $avatar, $description);

        self::assertEquals($author->getId(), $post->getAuthor()->getId());
        self::assertEquals($avatar, $post->getAvatar());
        self::assertEquals($description, $post->getDescription());
        self::assertNotNull($post->getId());
        self::assertNotNull($post->getDate());
        self::assertInstanceOf(Id::class, $post->getId());
        self::assertInstanceOf(DateTimeImmutable::class, $post->getDate());
    }
}
