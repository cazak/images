<?php

declare(strict_types=1);

namespace App\Controller\Users\My;

use App\Model\User\Application\Query\GetUserByNicknameOrId\Query;
use App\Model\User\Application\Query\GetUserByNicknameOrId\QueryHandler;
use App\Model\User\Domain\Entity\User;
use App\Service\ErrorHandler;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProfileAction extends AbstractController
{
    public function __construct(private readonly QueryHandler $queryHandler, private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/my/profile', name: 'app_my_profile')]
    public function show(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            /** @var User $user */
            $user = $this->getUser();

            return $this->render('my/profile.html.twig', [
                'user' => $this->queryHandler->fetch(new Query($user->getId()->getValue())),
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}
