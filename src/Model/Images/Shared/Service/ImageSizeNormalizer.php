<?php

declare(strict_types=1);

namespace App\Model\Images\Shared\Service;

use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class ImageSizeNormalizer
{
    public function __construct(
        private readonly ImageManager $imageManager,
        private readonly int $width,
        private readonly int $height,
    ) {
    }

    public function normalize(UploadedFile $uploadedFile): void
    {
        $image = $this->imageManager->make($uploadedFile->getRealPath());

        $image->resize($this->width, $this->height, static function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save();
    }
}
