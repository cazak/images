<?php

declare(strict_types=1);

namespace App\Controller\Images\Author\My;

use App\Controller\ErrorHandler;
use App\Model\Images\Author\Application\Query\GetAuthorByNicknameOrId\Query;
use App\Model\Images\Author\Application\Query\GetAuthorByNicknameOrId\QueryHandler;
use App\Model\Images\Post\Application\Query\GetPostsByAuthor\Query as PostQuery;
use App\Model\Images\Post\Application\Query\GetPostsByAuthor\QueryHandler as PostQueryHandler;
use App\Security\UserIdentity;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProfileAction extends AbstractController
{
    public function __construct(
        private readonly QueryHandler $queryHandler,
        private readonly PostQueryHandler $postQueryHandler,
        private readonly ErrorHandler $errorHandler
    ) {
    }

    #[Route('/my/profile', name: 'app_my_profile')]
    public function show(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            /** @var UserIdentity $user */
            $user = $this->getUser();

            return $this->render('images/author/my/profile.html.twig', [
                'author' => $this->queryHandler->fetch(new Query($user->getId())),
                'posts' => $this->postQueryHandler->fetch(new PostQuery($user->getId())),
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}
