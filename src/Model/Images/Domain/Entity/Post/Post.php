<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Entity\Post;

use Doctrine\ORM\Mapping as ORM;
use App\Model\Images\Domain\Entity\Author\Author;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;

#[ORM\Table(name: '`images_posts`')]
class Post
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid_id')]
    private Id $id;

    #[ORM\ManyToOne(targetEntity: Author::class, cascade: ['persist'])]
    private Author $author;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $avatar;

    #[ORM\Column(type: 'text', nullable: false)]
    private string $description;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $date;
}
