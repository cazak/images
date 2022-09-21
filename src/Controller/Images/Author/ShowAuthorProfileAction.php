<?php

declare(strict_types=1);

namespace App\Controller\Images\Author;

use App\Model\Images\Application\Author\Query\ShowAuthorProfile\Query;
use App\Model\Images\Application\Author\Query\ShowAuthorProfile\QueryHandler;
use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Service\ErrorHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShowAuthorProfileAction extends AbstractController
{
    public function __construct(
        private readonly QueryHandler $queryHandler,
        private readonly ErrorHandler $errorHandler,
        private readonly AuthorRepository $authorRepository,
    ) {
    }

    #[Route('/authors/{nicknameOrId}', name: 'app_authors_show')]
    public function show(string $nicknameOrId): Response
    {
        try {
            $currentAuthor = $this->authorRepository->get($this->getUser()->getId()->getValue());
            $author = $this->queryHandler->fetch(new Query($nicknameOrId, $currentAuthor->getId()->getValue()));

            if ($currentAuthor->getId()->getValue() === $author->author->id) {
                return $this->redirectToRoute('app_my_profile');
            }

            return $this->render('images/author/show.html.twig', [
                'author' => $author,
                'currentAuthor' => $currentAuthor,
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}