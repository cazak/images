<?php

declare(strict_types=1);

namespace App\Controller\Images\Author\My;

use App\Model\Images\Author\Application\Command\EditAbout\EditAboutCommand;
use App\Model\Images\Author\Application\Command\EditAbout\EditAboutCommandHandler;
use App\Model\Images\Author\Application\Command\EditAbout\EditAboutForm;
use App\Security\UserIdentity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AboutAction extends AbstractController
{
    #[Route('/profile/edit/about', name: 'app_edit_about')]
    public function edit(Request $request, EditAboutCommandHandler $handler): Response
    {
        /** @var UserIdentity $user */
        $user = $this->getUser();
        $command = new EditAboutCommand();
        $command->id = $user->getId();

        $form = $this->createForm(EditAboutForm::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($command);
        }

        return $this->redirectToRoute('app_my_profile');
    }
}
