<?php

declare(strict_types=1);

namespace App\Controller\Images\Author;

use App\Controller\ErrorHandler;
use App\Model\Images\Author\Application\Command\Subscribe\SubscribeCommand;
use App\Model\Images\Author\Application\Command\Subscribe\SubscribeCommandHandler;
use App\Model\Images\Author\Application\Command\UnSubscribe\UnSubscribeCommand;
use App\Model\Images\Author\Application\Command\UnSubscribe\UnSubscribeCommandHandler;
use App\Model\Shared\Service\UuidValidator;
use App\Security\UserIdentity;
use RedisException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SubscribeAction extends AbstractController
{
    public function __construct(private readonly ErrorHandler $errorHandler, private readonly UuidValidator $uuidValidator)
    {
    }

    #[Route('/subscribe/{id}', name: 'app_subscribe')]
    public function subscribe(string $id, SubscribeCommandHandler $handler): Response
    {
        $this->checkUuid($id);

        /** @var UserIdentity $user */
        $user = $this->getUser();
        $command = new SubscribeCommand($user->getId(), $id);
        try {
            $handler->handle($command);
        } catch (RedisException $e) {
            $this->errorHandler->handle($e);
        }

        return $this->redirectToRoute('app_authors_show', ['nicknameOrId' => $id]);
    }

    #[Route('/unsubscribe/{id}', name: 'app_unsubscribe')]
    public function unSubscribe(string $id, UnSubscribeCommandHandler $handler): Response
    {
        $this->checkUuid($id);

        /** @var UserIdentity $user */
        $user = $this->getUser();
        $command = new UnSubscribeCommand($user->getId(), $id);
        try {
            $handler->handle($command);
        } catch (RedisException $e) {
            $this->errorHandler->handle($e);
        }

        return $this->redirectToRoute('app_authors_show', ['nicknameOrId' => $id]);
    }

    private function checkUuid(string $id): void
    {
        if (!$this->uuidValidator->validate($id)) {
            $this->createNotFoundException();
        }
    }
}
