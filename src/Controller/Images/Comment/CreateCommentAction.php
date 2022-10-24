<?php

declare(strict_types=1);

namespace App\Controller\Images\Comment;

use App\Model\Images\Application\Comment\Command\Create\CreateCommentCommand;
use App\Model\Images\Application\Comment\Command\Create\CreateCommentCommandHandler;
use App\Model\Images\Application\Comment\Command\Create\CreateCommentForm;
use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Model\Images\Domain\Repository\Comment\CommentRepository;
use App\Model\Images\Infrastructure\Repository\Post\RedisPostRepository;
use App\Security\UserIdentity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateCommentAction extends AbstractController
{
    #[Route('/comment/create', name: 'app_comment_create', methods: ['POST'])]
    public function create(
        Request $request,
        CreateCommentCommandHandler $handler,
        CommentRepository $commentRepository,
        AuthorRepository $authorRepository,
        RedisPostRepository $redisPostRepository,
    ): Response {
        if ($request->isXmlHttpRequest()) {
            /** @var UserIdentity $user */
            $user = $this->getUser();
            $command = new CreateCommentCommand();
            $command->authorId = $user->getId();
            $command->postId = $request->query->get('postId');
            $form = $this->createForm(CreateCommentForm::class, $command);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $id = $handler->handle($command);

                return new JsonResponse([
                    'success' => true,
                    'commentsCount' => $redisPostRepository->getCommentsCount($command->postId),
                    'html' => $this->render('images/comment/comment.html.twig', [
                        'comment' => $commentRepository->get($id),
                        'author' => $authorRepository->get($user->getId()),
                        'postId' => $request->query->get('postId'),
                    ])->getContent(),
                ]);
            }

            return new JsonResponse([
                'success' => false,
                'errors' => $form->getErrors(),
            ]);
        }

        return new JsonResponse([
            'success' => false,
        ]);
    }
}
