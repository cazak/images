<?php

declare(strict_types=1);

namespace App\Model\Images\Application\Post\Command\Create;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

final class CreatePostCommand
{
    #[Assert\NotBlank]
    public string $authorId;

    #[Assert\NotBlank]
    #[Assert\File(
        maxSize: '1024k',
        mimeTypes: [
            'image/*',
        ],
        mimeTypesMessage: 'Please upload a valid JPG document'
    )]
    public UploadedFile $avatar;

    #[Assert\NotBlank]
    public string $description;

    public function __construct(string $authorId)
    {
        $this->authorId = $authorId;
    }
}
