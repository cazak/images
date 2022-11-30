<?php

declare(strict_types=1);

namespace App\Model\Images\Author\Infrastructure\Twig\Extension;

use App\Model\Images\Shared\Service\FileUploader;
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

    public function path(?string $avatar = null): string
    {
        if (!$avatar) {
            return '/img/default-user-avatar.jpg';
        }

        return $this->uploader->getPath($avatar);
    }
}
