<?php

declare(strict_types=1);

namespace App\Model\Images\Test\Author\Unit\Domain\Factory;

use App\Model\Images\Domain\Entity\Author\Author;
use App\Model\Images\Domain\Factory\Author\AuthorFactory;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class AuthorFactoryTest extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->factory = static::getContainer()->get(AuthorFactory::class);
    }

    public function testSuccess(): void
    {
        $id = Uuid::uuid4()->toString();
        $name = 'name';
        $surname = 'surname';
        $nickname = 'nickname';

        /** @var Author $author */
        $author = $this->factory->create($id, $name, $surname, $nickname);

        self::assertTrue($author->getStatus()->isActive());
        self::assertEquals($id, $author->getId()->getValue());
        self::assertEquals($name, $author->getName()->getName());
        self::assertEquals($surname, $author->getName()->getSurname());
        self::assertEquals($nickname, $author->getNickname());
        self::assertNotNull($author->getDate());
        self::assertNotNull($author->getId());
        self::assertInstanceOf(Id::class, $author->getId());
        self::assertInstanceOf(DateTimeImmutable::class, $author->getDate());
    }
}
