<?php

declare(strict_types=1);

namespace App\Controller\Images\Post;

use App\Controller\ErrorHandler;
use App\Model\Images\Post\Application\Command\Create\CreatePostCommand;
use App\Model\Images\Post\Application\Command\Create\CreatePostCommandHandler;
use App\Model\Images\Post\Application\Command\Create\CreatePostForm;
use App\Security\UserIdentity;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreatePostAction extends AbstractController
{
    public function __construct(private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/post/create', name: 'app_post_create')]
    public function create(Request $request, CreatePostCommandHandler $handler): Response
    {
        /** @var UserIdentity $user */
        $user = $this->getUser();

        $command = new CreatePostCommand($user->getId());

        $form = $this->createForm(CreatePostForm::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $postId = $handler->handle($command);
                $this->addFlash('success', 'Post successfully created.');

                return $this->redirectToRoute('app_show_post', ['id' => $postId]);
            } catch (Exception $e) {
                $this->errorHandler->handle($e);
                $this->addFlash('error', $e->getMessage());

                return $this->redirectToRoute('app_me');
            }
        }

        return $this->render('images/post/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
