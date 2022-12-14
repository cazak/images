<?php

declare(strict_types=1);

namespace App\Controller\Images\Post;

use App\Controller\ErrorHandler;
use App\Model\Images\Post\Application\Command\Like\LikePostCommand;
use App\Model\Images\Post\Application\Command\Like\LikePostCommandHandler;
use App\Model\Images\Post\Application\Command\Unlike\UnlikePostCommand;
use App\Model\Images\Post\Application\Command\Unlike\UnlikePostCommandHandler;
use App\Security\UserIdentity;
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
                /** @var UserIdentity $user */
                $user = $this->getUser();
                $command = new LikePostCommand($user->getId(), $request->get('postId'));
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
                /** @var UserIdentity $user */
                $user = $this->getUser();
                $command = new UnlikePostCommand($user->getId(), $request->get('postId'));
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
