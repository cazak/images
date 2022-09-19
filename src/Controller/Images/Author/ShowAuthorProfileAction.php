<?php

declare(strict_types=1);

namespace App\Controller\Images\Author;

use App\Model\Images\Application\Author\Query\ShowAuthorProfile\Query;
use App\Model\Images\Application\Author\Query\ShowAuthorProfile\QueryHandler;
use App\Service\ErrorHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShowAuthorProfileAction extends AbstractController
{
    public function __construct(private readonly QueryHandler $queryHandler, private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/authors/{nicknameOrId}', name: 'app_authors_show')]
    public function show(string $nicknameOrId): Response
    {
        try {
            return $this->render('images/author/show.html.twig', [
                'author' => $this->queryHandler->fetch(new Query($nicknameOrId, $this->getUser()->getId()->getValue())),
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}
