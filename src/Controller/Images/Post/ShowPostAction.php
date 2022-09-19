<?php

declare(strict_types=1);

namespace App\Controller\Images\Post;

use App\Model\Images\Application\Post\Query\GetPostById\Query;
use App\Model\Images\Application\Post\Query\GetPostById\QueryHandler;
use App\Service\ErrorHandler;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShowPostAction extends AbstractController
{
    public function __construct(private readonly QueryHandler $queryHandler, private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/post/show/{id}', name: 'app_show_post')]
    public function show(string $id): Response
    {
        try {
            return $this->render('images/post/show.html.twig', [
                'post' => $this->queryHandler->fetch(new Query($id)),
            ]);
        } catch (Exception $e) {
            $this->errorHandler->handle($e);
            $this->addFlash('error', $e->getMessage());

            return $this->redirectToRoute('app_my_profile');
        }
    }
}
