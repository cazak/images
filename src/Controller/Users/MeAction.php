<?php

declare(strict_types=1);

namespace App\Controller\Users;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MeAction extends AbstractController
{
    #[Route('/me', name: 'app_me')]
    public function me(): Response
    {
        return $this->render('users/me.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
