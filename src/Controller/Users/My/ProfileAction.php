<?php

declare(strict_types=1);

namespace App\Controller\Users\My;

use App\Model\User\Application\Command\ChangeAvatar\ChangeAvatarCommand;
use App\Model\User\Application\Command\ChangeAvatar\ChangeAvatarCommandHandler;
use App\Model\User\Application\Command\ChangeAvatar\ChangeAvatarForm;
use App\Model\User\Application\Query\GetUserByNicknameOrId\Query;
use App\Model\User\Application\Query\GetUserByNicknameOrId\QueryHandler;
use App\Model\User\Domain\Entity\User;
use App\Service\ErrorHandler;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProfileAction extends AbstractController
{
    public function __construct(private readonly QueryHandler $queryHandler, private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/my/profile', name: 'app_my_profile')]
    public function show(Request $request, ChangeAvatarCommandHandler $handler): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $user = $this->getUser();

            $command = new ChangeAvatarCommand();
            $form = $this->createForm(ChangeAvatarForm::class, $command);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $command->id = $user->getId()->getValue();
                $handler->handle($command);
            }

            /** @var User $user */

            return $this->render('my/profile.html.twig', [
                'user' => $this->queryHandler->fetch(new Query($user->getId()->getValue())),
                'form' => $form->createView()
            ]);
        } catch (Exception $exception) {
            $this->errorHandler->handle($exception);
            throw $this->createNotFoundException();
        }
    }
}
