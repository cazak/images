<?php

namespace App\Model\Images\Application\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploader
{
    public function upload(UploadedFile $file): string;

    public function remove(string $file): void;

    public function getPath(string $avatar): string;
}
