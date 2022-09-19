<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Author\Command\ChangeAvatar;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

final class ChangeAvatarCommand
{
    public string $id;

    #[Assert\NotBlank]
    #[Assert\File(
        maxSize: '1024k',
        mimeTypes: [
            'image/*',
        ],
        mimeTypesMessage: 'Please upload a valid JPG document'
    )]
    public ?UploadedFile $avatar;
}
