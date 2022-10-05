<?php

declare(strict_types=1);

namespace App\Model\User\Test\Unit\Domain\Entity;

use App\Model\User\Domain\Entity\Name;
use App\Model\User\Test\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;

final class ChangeNameTest extends TestCase
{
    public function test_success(): void
    {
        $name = new Name('test', 'test');
        $user = (new UserBuilder())->viaName($name)->build();

        self::assertEquals($name->getName(), $user->getName()->getName());
        self::assertEquals($name->getSurname(), $user->getName()->getSurname());

        $newName = new Name('first', 'last');
        $user->changeName($newName);

        self::assertEquals($newName->getName(), $user->getName()->getName());
        self::assertEquals($newName->getSurname(), $user->getName()->getSurname());

        self::assertNotEquals($name->getName(), $user->getName()->getName());
        self::assertNotEquals($name->getSurname(), $user->getName()->getSurname());
    }

    public function test_already(): void
    {
        $name = new Name('test', 'test');
        $user = (new UserBuilder())->viaName($name)->build();

        $this->expectExceptionMessage('Name is already same.');
        $user->changeName($name);
    }
}
