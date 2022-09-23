<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Entity\Feed;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class Post
{
    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $date;

    #[ORM\Column(type: 'text', nullable: false)]
    private string $description;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $avatar;

    public function __construct(DateTimeImmutable $date, string $description, string $avatar)
    {
        Assert::notEmpty($description);
        Assert::notEmpty($avatar);

        $this->date = $date;
        $this->description = $description;
        $this->avatar = $avatar;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }
}
