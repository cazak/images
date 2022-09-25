<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Comment\Command\Create;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateCommentCommand
{
    #[Assert\NotBlank]
    public string $authorId;

    #[Assert\NotBlank]
    public string $postId;

    #[Assert\NotBlank]
    public string $text;
}
