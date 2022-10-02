<?php

declare(strict_types=1);

namespace App\Controller\Images\Comment;

use App\Model\Images\Application\Comment\Command\Edit\EditCommentCommand;
use App\Model\Images\Application\Comment\Command\Edit\EditCommentCommandHandler;
use App\Model\Images\Domain\Repository\Author\AuthorRepository;
use App\Model\Images\Domain\Repository\Comment\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UpdateCommentAction extends AbstractController
{
    #[Route('/comment/update', name: 'app_comment_update', methods: ['POST'])]
    public function update(
        Request $request,
        EditCommentCommandHandler $handler,
        CommentRepository $commentRepository,
        ValidatorInterface $validator,
    ): Response {
        if ($request->isXmlHttpRequest()) {
            if ($this->getUser()->getId()->getValue() !== $request->request->get('author_id')) {
                $this->createNotFoundException();
            }
            $command = new EditCommentCommand();
            $command->id = $request->request->get('comment_id');
            $command->text = $request->request->get('text');

            $errors = $validator->validate($command);

            if (count($errors) > 0) {
                return new JsonResponse([
                    'success' => false,
                    'errors' => (string) $errors,
                ]);
            }

            $id = $handler->handle($command);

            return new JsonResponse([
                'success' => true,
                'text' => $commentRepository->get($id)->getText(),
            ]);
        }

        return new JsonResponse([
            'success' => 'false',
        ]);
    }

    #[Route('/comment/update-form', name: 'app_comment_update-form', methods: ['GET'])]
    public function getFormHtml(
        Request $request,
        CommentRepository $commentRepository,
        AuthorRepository $authorRepository,
    ): Response {
        return new JsonResponse([
            'success' => true,
            'html' => $this->render('images/comment/update-form.html.twig', [
                'comment' => $commentRepository->get($request->query->get('comment_id')),
                'author' => $authorRepository->get($request->query->get('author_id')),
            ])->getContent(),
        ]);
    }
}
