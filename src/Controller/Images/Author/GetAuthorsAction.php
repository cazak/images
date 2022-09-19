<?php

declare(strict_types=1);

namespace App\Controller\Images\Author;

use App\Model\Images\Application\Author\Query\GetAuthors\Filter;
use App\Model\Images\Application\Author\Query\GetAuthors\Form;
use App\Model\Images\Application\Author\Query\GetAuthors\QueryHandler;
use App\Service\ErrorHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetAuthorsAction extends AbstractController
{
    public const ITEMS_PER_PAGE = 2;

    public function __construct(private readonly QueryHandler $queryHandler, private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/authors', name: 'app_authors_list', methods: ['GET'])]
    public function index(Request $request): Response
    {
        try {
            $filter = new Filter(
                $request->query->get('sort', 'status'),
                $request->query->get('order', 'asc'),
                $request->query->getInt('page', 1),
                self::ITEMS_PER_PAGE,
            );
            $form = $this->createForm(Form::class, $filter);

            $form->handleRequest($request);

            return $this->render('images/author/index.html.twig', [
                'pagination' => $this->queryHandler->fetch($filter),
                'form' => $form->createView(),
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}
