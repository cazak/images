<?php

declare(strict_types=1);

namespace App\Controller\Images\Author\My;

use App\Model\Images\Application\Post\Query\GetPostsByAuthor\QueryHandler as PostQueryHandler;
use App\Model\Images\Application\Post\Query\GetPostsByAuthor\Query as PostQuery;
use App\Model\Images\Application\Author\Command\ChangeAvatar\ChangeAvatarCommand;
use App\Model\Images\Application\Author\Command\ChangeAvatar\ChangeAvatarForm;
use App\Model\Images\Application\Author\Query\GetAuthorByNicknameOrId\Query;
use App\Model\Images\Application\Author\Query\GetAuthorByNicknameOrId\QueryHandler;
use App\Model\User\Domain\Entity\User;
use App\Service\ErrorHandler;
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
            /* @var User $user */
            $user = $this->getUser();

            return $this->render('images/author/my/profile.html.twig', [
                'author' => $this->queryHandler->fetch(new Query($user->getId()->getValue())),
                'posts' => $this->postQueryHandler->fetch(new PostQuery($user->getId()->getValue())),
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}
