<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserIdentity implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private readonly string $id,
        private readonly string $role,
        private readonly string $name,
        private readonly string $surname,
        private readonly string $email,
        private readonly string $password,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return [$this->role];
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
    }
}
