<?php

declare(strict_types=1);

namespace App\Controller\Users\My;

use App\Model\User\Application\Command\ChangeAvatar\ChangeAvatarCommand;
use App\Model\User\Application\Command\ChangeAvatar\ChangeAvatarCommandHandler;
use App\Model\User\Application\Command\ChangeAvatar\ChangeAvatarForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AvatarAction extends AbstractController
{
    #[Route('/avatar/change', name: 'app_change_avatar')]
    public function avatar(Request $request, ChangeAvatarCommandHandler $handler): Response
    {
        $user = $this->getUser();

        $command = new ChangeAvatarCommand();
        $form = $this->createForm(ChangeAvatarForm::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command->id = $user->getId()->getValue();
            $handler->handle($command);
        }

        return $this->redirectToRoute('app_my_profile');
    }

    #[Route('/avatar/remove', name: 'app_remove_avatar')]
    public function removeAvatar(ChangeAvatarCommandHandler $handler)
    {
        $user = $this->getUser();

        $command = new ChangeAvatarCommand();
        $command->id = $user->getId()->getValue();
        $command->avatar = null;

        $handler->handle($command);

        return $this->redirectToRoute('app_my_profile');
    }
}
