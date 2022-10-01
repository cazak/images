<?php

declare(strict_types=1);

namespace App\Model\User\Domain\Entity;

use App\Model\Shared\Domain\Entity\AggregateRoot;
use App\Model\Shared\Domain\Entity\EventsTrait;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use App\Model\User\Infrastructure\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user_users`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, AggregateRoot
{
    use EventsTrait;

    public const STATUS_WAIT = 1;
    public const STATUS_ACTIVE = 2;

    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    #[ORM\Id]
    #[ORM\Column(type: 'uuid_id')]
    private Id $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $date;

    #[ORM\Embedded(class: Name::class, columnPrefix: false)]
    private Name $name;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(name: 'confirm_token', type: 'string', length: 255, nullable: true)]
    private ?string $confirmToken;

    #[ORM\Column(type: 'integer')]
    private ?int $status;

    #[ORM\Column(type: 'user_user_email', nullable: true)]
    private Email $email;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $role = null;

    #[ORM\Column(type: 'boolean')]
    private bool $isVerified;

    public function __construct(Id $id, Email $email, DateTimeImmutable $date, Name $name)
    {
        $this->id = $id;
        $this->email = $email;
        $this->date = $date;
        $this->name = $name;
        $this->isVerified = false;
        $this->status = self::STATUS_WAIT;
    }

    public function confirmSignUp(): self
    {
        $this->confirmToken = null;
        $this->isVerified = true;
        $this->status = self::STATUS_ACTIVE;

        return $this;
    }

    public function changeName(Name $name): void
    {
        if ($this->name->isEqual($name)) {
            throw new DomainException('Name is already same.');
        }

        $this->name = $name;

        $this->recordEvent(new Event\UserNameUpdatedEvent(
            $this->id,
            $this->name
        ));
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function setName(Name $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getConfirmToken(): ?string
    {
        return $this->confirmToken;
    }

    public function setConfirmToken(string $token): self
    {
        $this->confirmToken = $token;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email->getValue();
    }
}
