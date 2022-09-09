<?php

declare(strict_types=1);

namespace App\Controller\Users;

use App\Model\User\Application\Query\GetUsers\Query;
use App\Model\User\Application\Query\GetUsers\QueryHandler;
use App\Service\ErrorHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetUsersAction extends AbstractController
{
    public function __construct(private readonly QueryHandler $queryHandler, private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/users', name: 'app_users_list')]
    public function index(Request $request): Response
    {
        try {
            return $this->render('users/index.html.twig', [
                'users' => $this->queryHandler->fetch(new Query())
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}
