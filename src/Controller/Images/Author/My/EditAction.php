<?php

declare(strict_types=1);

namespace App\Controller\Images\Author\My;

use App\Model\Images\Application\Author\Command\ChangeAvatar\ChangeAvatarCommand;
use App\Model\Images\Application\Author\Command\ChangeAvatar\ChangeAvatarForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EditAction extends AbstractController
{
    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(): Response
    {
        $command = new ChangeAvatarCommand();
        $form = $this->createForm(ChangeAvatarForm::class, $command);

        return $this->render('images/author/my/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
