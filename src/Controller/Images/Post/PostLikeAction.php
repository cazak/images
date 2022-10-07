<?php

declare(strict_types=1);

namespace App\Controller\Images\Post;

use App\Model\Images\Application\Post\Command\Like\LikePostCommand;
use App\Model\Images\Application\Post\Command\Like\LikePostCommandHandler;
use App\Model\Images\Application\Post\Command\Unlike\UnlikePostCommand;
use App\Model\Images\Application\Post\Command\Unlike\UnlikePostCommandHandler;
use App\Service\ErrorHandler;
use RedisException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PostLikeAction extends AbstractController
{
    public function __construct(private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/post/like', name: 'app_post_like', methods: ['POST'])]
    public function like(Request $request, LikePostCommandHandler $handler): Response
    {
        if ($request->isXmlHttpRequest()) {
            try {
                $command = new LikePostCommand($this->getUser()->getId(), $request->get('postId'));
                $likesCount = $handler->handle($command);
            } catch (RedisException $e) {
                $this->errorHandler->handle($e);

                return $this->json(['success' => false, 'error' => $e->getMessage()]);
            }

            return $this->json(['success' => true, 'likesCount' => $likesCount]);
        }

        return $this->json(['success' => false]);
    }

    #[Route('/post/unlike', name: 'app_post_unlike')]
    public function unlike(Request $request, UnlikePostCommandHandler $handler): Response
    {
        if ($request->isXmlHttpRequest()) {
            try {
                $command = new UnlikePostCommand($this->getUser()->getId(), $request->get('postId'));
                $likesCount = $handler->handle($command);
            } catch (RedisException $e) {
                $this->errorHandler->handle($e);

                return $this->json(['success' => false, 'error' => $e->getMessage()]);
            }

            return $this->json(['success' => true, 'likesCount' => $likesCount]);
        }

        return $this->json(['success' => false]);
    }
}
