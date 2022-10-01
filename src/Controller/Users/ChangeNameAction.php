<?php

declare(strict_types=1);

namespace App\Controller\Users;

use App\Model\User\Application\Command\UpdateName\UpdateNameCommand;
use App\Model\User\Application\Command\UpdateName\UpdateNameCommandHandler;
use App\Model\User\Application\Command\UpdateName\UpdateNameForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ChangeNameAction extends AbstractController
{
    #[Route('/edit/name', name: 'app_change_name')]
    public function change(Request $request, UpdateNameCommandHandler $handler): Response
    {
        $command = new UpdateNameCommand($this->getUser()->getId()->getValue());
        $form = $this->createForm(UpdateNameForm::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handle($command);

            $this->addFlash('success', 'Name successfully changed.');

            return $this->redirectToRoute('app_me');
        }

        return $this->render('users/change-name.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
