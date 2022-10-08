<?php

declare(strict_types=1);

namespace App\Controller\Images\Post;

use App\Model\Images\Application\Comment\Command\Create\CreateCommentCommand;
use App\Model\Images\Application\Comment\Command\Create\CreateCommentForm;
use App\Model\Images\Application\Comment\Query\GetCommentsByPost\Query as CommentQuery;
use App\Model\Images\Application\Comment\Query\GetCommentsByPost\QueryHandler as CommentQueryHandler;
use App\Model\Images\Application\Post\Query\GetPostById\Query;
use App\Model\Images\Application\Post\Query\GetPostById\QueryHandler;
use App\Service\ErrorHandler;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ShowPostAction extends AbstractController
{
    public function __construct(
        private readonly QueryHandler $queryHandler,
        private readonly CommentQueryHandler $commentQueryHandler,
        private readonly ErrorHandler $errorHandler
    ) {
    }

    #[Route('/post/show/{id}', name: 'app_show_post')]
    public function show(string $id): Response
    {
        try {
            $command = new CreateCommentCommand();
            $command->authorId = $this->getUser()->getId();
            $form = $this->createForm(CreateCommentForm::class, $command);

            $post = $this->queryHandler->fetch(new Query($id, $this->getUser()->getId()));

            return $this->render('images/post/show.html.twig', [
                'post' => $this->queryHandler->fetch(new Query($id, $this->getUser()->getId())),
                'comments' => $this->commentQueryHandler->fetch(new CommentQuery($post->id)),
                'form' => $form->createView(),
            ]);
        } catch (Exception $e) {
            $this->errorHandler->handle($e);
            $this->addFlash('error', $e->getMessage());

            return $this->redirectToRoute('app_my_profile');
        }
    }
}
