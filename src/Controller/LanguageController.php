<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class LanguageController extends AbstractController
{
    #[Route('/language/change', name: 'app_change_language')]
    public function change(Request $request): JsonResponse
    {
        $language = $request->query->get('language');
        $this->checkLanguages($language);

        $jsonResponse = new JsonResponse([
            'success' => true,
        ]);

        $jsonResponse->headers->setCookie(Cookie::create('language', $language));

        return $jsonResponse;
    }

    private function checkLanguages(?string $language = null): void
    {
        if (!$language) {
            throw $this->createNotFoundException();
        }

        if (!in_array($language, $this->getParameter('supported_locales'), true)) {
            throw $this->createNotFoundException();
        }
    }
}
