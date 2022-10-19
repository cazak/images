<?php

declare(strict_types=1);

namespace App\Widget\Language;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class LanguageWidget extends AbstractExtension
{
    public function __construct(private readonly RequestStack $request)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('language_selector', [$this, 'languageSelector'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function languageSelector(Environment $twig): string
    {
        return $twig->render('widget/language/select.html.twig', [
            'locale' => $this->request->getCurrentRequest()->getLocale(),
        ]);
    }
}
