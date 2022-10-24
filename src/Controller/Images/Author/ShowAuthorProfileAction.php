<?php

declare(strict_types=1);

namespace App\Controller\Images\Author;

use App\Model\Images\Application\Author\Query\ShowAuthorProfile\Query;
use App\Model\Images\Application\Author\Query\ShowAuthorProfile\QueryHandler;
use App\Model\Images\Application\Post\Query\GetPostsByAuthor\Query as PostQuery;
use App\Model\Images\Application\Post\Query\GetPostsByAuthor\QueryHandler as PostQueryHandler;
use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Security\UserIdentity;
use App\Service\ErrorHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShowAuthorProfileAction extends AbstractController
{
    public function __construct(
        private readonly QueryHandler $queryHandler,
        private readonly PostQueryHandler $postQueryHandler,
        private readonly ErrorHandler $errorHandler,
        private readonly AuthorRepository $authorRepository,
    ) {
    }

    #[Route('/authors/{nicknameOrId}', name: 'app_authors_show')]
    public function show(string $nicknameOrId): Response
    {
        try {
            /** @var UserIdentity $user */
            $user = $this->getUser();
            $currentAuthor = $this->authorRepository->get($user->getId());
            $author = $this->queryHandler->fetch(new Query($nicknameOrId, $currentAuthor->getId()->getValue()));

            if ($currentAuthor->getId()->getValue() === $author->author->id) {
                return $this->redirectToRoute('app_my_profile');
            }

            return $this->render('images/author/show.html.twig', [
                'author' => $author,
                'posts' => $this->postQueryHandler->fetch(new PostQuery($author->author->id)),
                'currentAuthor' => $currentAuthor,
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}
