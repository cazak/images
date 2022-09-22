<?php

namespace App\Model\Images\Application\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageSizeNormalizer
{
    public function normalize(UploadedFile $uploadedFile): void;
}
