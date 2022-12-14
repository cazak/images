<?php

declare(strict_types=1);

namespace App\Controller\Images\Post;

use App\Controller\ErrorHandler;
use App\Model\Images\Comment\Application\Command\Create\CreateCommentCommand;
use App\Model\Images\Comment\Application\Command\Create\CreateCommentForm;
use App\Model\Images\Comment\Application\Query\GetCommentsByPost\Query as CommentQuery;
use App\Model\Images\Comment\Application\Query\GetCommentsByPost\QueryHandler as CommentQueryHandler;
use App\Model\Images\Post\Application\Query\GetPostById\Query;
use App\Model\Images\Post\Application\Query\GetPostById\QueryHandler;
use App\Security\UserIdentity;
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
            /** @var UserIdentity $user */
            $user = $this->getUser();
            $command = new CreateCommentCommand();
            $command->authorId = $user->getId();
            $form = $this->createForm(CreateCommentForm::class, $command);

            $post = $this->queryHandler->fetch(new Query($id, $user->getId()));

            return $this->render('images/post/show.html.twig', [
                'post' => $this->queryHandler->fetch(new Query($id, $user->getId())),
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
