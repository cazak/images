<?php

declare(strict_types=1);

namespace App\Controller\Users;

use App\Model\User\Application\Query\FindUserByNicknameOrId\Query;
use App\Model\User\Application\Query\FindUserByNicknameOrId\QueryHandler;
use App\Service\ErrorHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShowUserProfileAction extends AbstractController
{
    public function __construct(private readonly QueryHandler $queryHandler, private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/users/show/{nicknameOrId}', name: 'app_users_show')]
    public function show(string $nicknameOrId): Response
    {
        try {
            return $this->render('users/show.html.twig', [
                'user' => $this->queryHandler->fetch(new Query($nicknameOrId))
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}
