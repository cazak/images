<?php

declare(strict_types=1);

namespace App\Controller\Images\Author;

use App\Model\Images\Application\Author\Command\Subscribe\SubscribeCommand;
use App\Model\Images\Application\Author\Command\Subscribe\SubscribeCommandHandler;
use App\Model\Images\Application\Author\Command\UnSubscribe\UnSubscribeCommand;
use App\Model\Images\Application\Author\Command\UnSubscribe\UnSubscribeCommandHandler;
use App\Model\Shared\Service\UuidValidator;
use App\Model\User\Domain\Entity\User;
use App\Service\ErrorHandler;
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

        /** @var User $user */
        $user = $this->getUser();
        $command = new SubscribeCommand($user->getId()->getValue(), $id);
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

        /** @var User $user */
        $user = $this->getUser();
        $command = new UnSubscribeCommand($user->getId()->getValue(), $id);
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
