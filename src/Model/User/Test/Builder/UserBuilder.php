<?php

declare(strict_types=1);

namespace App\Model\User\Test\Builder;

use App\Model\Shared\Domain\Entity\ValueObject\Id;
use App\Model\Shared\Infrastructure\Service\Assert;
use App\Model\User\Application\Service\ConfirmTokenGenerator;
use App\Model\User\Domain\Entity\Email;
use App\Model\User\Domain\Entity\Name;
use App\Model\User\Domain\Entity\User;
use DateTimeImmutable;

final class UserBuilder
{
    private Id $id;
    private Email $email;
    private DateTimeImmutable $date;
    private Name $name;
    private bool $isConfirmed;
    private string $role;

    public function __construct()
    {
        $this->id = Id::next();
        $this->email = new Email('test@test.com');
        $this->date = new DateTimeImmutable();
        $this->name = new Name('first', 'last');
        $this->role = User::ROLE_USER;
        $this->isConfirmed = false;
    }

    public function viaEmail(Email $email): self
    {
        $clone = clone $this;
        $clone->email = $email;

        return $clone;
    }

    public function viaName(Name $name): self
    {
        $clone = clone $this;
        $clone->name = $name;

        return $clone;
    }

    public function viaRole(string $role): self
    {
        Assert::oneOf($role, [
            User::ROLE_USER,
            User::ROLE_ADMIN,
        ]);

        $clone = clone $this;
        $clone->role = $role;

        return $clone;
    }

    public function confirmed(): self
    {
        $clone = clone $this;
        $clone->isConfirmed = true;

        return $clone;
    }

    public function build(): User
    {
        $user = new User($this->id, $this->email, $this->date, $this->name);

        if ($this->isConfirmed) {
            $user->confirmSignUp();
        } else {
            $generator = new ConfirmTokenGenerator();
            $user->setConfirmToken($generator->generate());
        }

        $user->setRole($this->role);

        return $user;
    }
}
