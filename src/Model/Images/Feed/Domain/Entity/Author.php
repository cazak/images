<?php

declare(strict_types=1);

namespace App\Model\Images\Feed\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class Author
{
    #[ORM\Embedded(class: AuthorName::class, columnPrefix: false)]
    private AuthorName $authorName;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $nickname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $avatar;

    public function __construct(AuthorName $authorName, string $nickname, ?string $avatar = null)
    {
        Assert::notEmpty($nickname);

        $this->authorName = $authorName;
        $this->nickname = $nickname;
        $this->avatar = $avatar;
    }

    public function getName(): AuthorName
    {
        return $this->authorName;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }
}
