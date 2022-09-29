<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Command\EditAbout;

use Symfony\Component\Validator\Constraints as Assert;

final class EditAboutCommand
{
    #[Assert\NotBlank]
    public string $id;

    public ?string $about = null;
}
