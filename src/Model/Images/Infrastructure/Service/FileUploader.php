<?php

declare(strict_types=1);

namespace App\Model\Images\Infrastructure\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final class FileUploader
{
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly string $directory,
        private readonly Filesystem $filesystem
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move(
            $this->directory . '/' . date('Y-m-d'),
            $newFilename
        );

        return date('Y-m-d') . '/' . $newFilename;
    }

    public function remove(string $file): void
    {
        $this->filesystem->remove($this->directory . '/' . $file);
    }
}
