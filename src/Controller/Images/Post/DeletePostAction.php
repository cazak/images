<?php

declare(strict_types=1);

namespace App\Controller\Images\Post;

use App\Model\Images\Application\Post\Command\Remove\RemovePostCommand;
use App\Model\Images\Application\Post\Command\Remove\RemovePostCommandHandler;
use App\Model\Images\Domain\Entity\Post\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DeletePostAction extends AbstractController
{
    #[Route('/post/delete/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Post $post, Request $request, RemovePostCommandHandler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete-post', $request->request->get('token'))) {
            $this->createNotFoundException();
        }
        if ($this->getUser()->getId() !== $request->request->get('author_id')) {
            $this->createNotFoundException();
        }
        $command = new RemovePostCommand();
        $command->postId = $post->getId()->getValue();
        $command->authorId = $this->getUser()->getId();

        $handler->handle($command);
        $this->addFlash('success', 'Post deleted.');

        return $this->redirectToRoute('app_my_profile');
    }
}
