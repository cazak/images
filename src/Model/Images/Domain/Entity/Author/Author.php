<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Entity\Author;

use App\Model\Shared\Domain\Entity\ValueObject\Id;
use App\Model\User\Domain\Entity\Name;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: '`post_authors`')]
class Author
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid_id')]
    private Id $id;

    #[ORM\Column(type: 'string', length: 255, unique: true, nullable: true)]
    private string $nickname;

    #[ORM\Embedded(class: Name::class, columnPrefix: false)]
    private Name $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $avatar;
}
