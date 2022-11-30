<?php

declare(strict_types=1);

namespace App\Model\Images\Comment\Application\Command\Edit;

use Symfony\Component\Validator\Constraints as Assert;

final class EditCommentCommand
{
    #[Assert\NotBlank]
    public string $id;

    #[Assert\NotBlank]
    public string $text;
}
