<?php

declare(strict_types=1);

namespace App\Model\Images\Domain\Entity\Feed;

use App\Model\Images\Domain\Entity\Author\Author as AuthorEntity;
use App\Model\Images\Domain\Entity\Post\Post as PostEntity;
use App\Model\Shared\Domain\Entity\ValueObject\Id;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: '`images_feeds`')]
class Feed
{
    use FeedAnemic;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid_id')]
    private Id $id;

    #[ORM\ManyToOne(targetEntity: AuthorEntity::class, cascade: ['persist'])]
    private AuthorEntity $reader;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $date;

    #[ORM\ManyToOne(targetEntity: PostEntity::class, cascade: ['persist'])]
    private PostEntity $post;

    #[ORM\Embedded(class: Post::class, columnPrefix: 'post_')]
    private Post $postData;

    #[ORM\ManyToOne(targetEntity: AuthorEntity::class, cascade: ['persist'])]
    private AuthorEntity $author;

    #[ORM\Embedded(class: Author::class, columnPrefix: 'author_')]
    private Author $authorData;

    public function __construct(
        Id $id,
        DateTimeImmutable $date,
        AuthorEntity $reader,
        PostEntity $post,
        Post $postData,
        AuthorEntity $author,
        Author $authorData,
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->reader = $reader;
        $this->postData = $postData;
        $this->post = $post;
        $this->author = $author;
        $this->authorData = $authorData;
    }
}