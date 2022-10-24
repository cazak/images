<?php

declare(strict_types=1);

namespace App\Controller\Images\Author\My;

use App\Model\Images\Application\Author\Command\ChangeAvatar\ChangeAvatarCommand;
use App\Model\Images\Application\Author\Command\ChangeAvatar\ChangeAvatarCommandHandler;
use App\Model\Images\Application\Author\Command\ChangeAvatar\ChangeAvatarForm;
use App\Security\UserIdentity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AvatarAction extends AbstractController
{
    #[Route('/avatar/change', name: 'app_change_avatar')]
    public function avatar(Request $request, ChangeAvatarCommandHandler $handler): Response
    {
        /** @var UserIdentity $user */
        $user = $this->getUser();

        $command = new ChangeAvatarCommand();
        $form = $this->createForm(ChangeAvatarForm::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command->id = $user->getId();
            $handler->handle($command);
        }

        return $this->redirectToRoute('app_my_profile');
    }

    #[Route('/avatar/remove', name: 'app_remove_avatar')]
    public function removeAvatar(ChangeAvatarCommandHandler $handler): Response
    {
        /** @var UserIdentity $user */
        $user = $this->getUser();

        $command = new ChangeAvatarCommand();
        $command->id = $user->getId();
        $command->avatar = null;

        $handler->handle($command);

        return $this->redirectToRoute('app_my_profile');
    }
}
