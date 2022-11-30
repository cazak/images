<?php

declare(strict_types=1);

namespace App\Controller\Images\Author;

use App\Model\Images\Author\Application\Command\Create\CreateAuthorCommand;
use App\Model\Images\Author\Application\Command\Create\CreateAuthorCommandHandler;
use App\Model\Images\Author\Application\Command\Create\CreateAuthorForm;
use App\Model\Images\Author\Application\Command\Exceptions\NicknameIsAlreadyInUse;
use App\Security\UserIdentity;
use App\Service\ErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateAuthorAction extends AbstractController
{
    public function __construct(private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/author/create', name: 'app_author_create')]
    public function create(Request $request, CreateAuthorCommandHandler $handler): Response
    {
        /** @var UserIdentity $user */
        $user = $this->getUser();

        $command = new CreateAuthorCommand($user->getId());

        $command->name = $user->getName();
        $command->surname = $user->getSurname();

        $form = $this->createForm(CreateAuthorForm::class, $command);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Author successfully created.');

                return $this->redirectToRoute('app_my_profile');
            } catch (NicknameIsAlreadyInUse $e) {
                $this->errorHandler->handle($e);
                $this->addFlash('error', 'This nickname is already in use.');

                return $this->redirectToRoute('app_me');
            }
        }

        return $this->render('images/author/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
