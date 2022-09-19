<?php

declare(strict_types=1);

namespace App\Twig\Extension\Images\Author;

use App\Model\Images\Infrastructure\Service\FileUploader;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class StoragePathExtension extends AbstractExtension
{
    public function __construct(private readonly FileUploader $uploader)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('author_path', [$this, 'path']),
        ];
    }

    public function path(string $avatar): string
    {
        return $this->uploader->getPath($avatar);
    }
}
