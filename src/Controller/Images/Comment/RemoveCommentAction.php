<?php

declare(strict_types=1);

namespace App\Controller\Images\Comment;

use App\Model\Images\Application\Comment\Command\Remove\RemoveCommentCommand;
use App\Model\Images\Application\Comment\Command\Remove\RemoveCommentCommandHandler;
use App\Model\Images\Domain\Entity\Comment\Comment;
use App\Service\ErrorHandler;
use RedisException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RemoveCommentAction extends AbstractController
{
    #[Route('/comment/remove/{id}', name: 'app_comment_remove', methods: ['POST'])]
    public function remove(
        Comment $comment,
        Request $request,
        RemoveCommentCommandHandler $handler,
        ErrorHandler $errorHandler,
    ): Response {
        if (!$this->isCsrfTokenValid('delete-comment', $request->request->get('token'))) {
            $this->createNotFoundException();
        }
        if ($this->getUser()->getId()->getValue() !== $request->request->get('author_id')) {
            $this->createNotFoundException();
        }
        $command = new RemoveCommentCommand();
        $command->postId = $request->request->get('post_id');
        $command->commentId = $comment->getId()->getValue();
        try {
            $handler->handle($command);
        } catch (RedisException $e) {
            $this->addFlash('error', 'Error');
            $errorHandler->handle($e);
        }

        return $this->redirectToRoute('app_show_post', ['id' => $request->request->get('post_id')]);
    }
}
