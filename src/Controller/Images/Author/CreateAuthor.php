<?php

declare(strict_types=1);

namespace App\Controller\Images\Author;

use App\Model\Images\Application\Author\Command\Create\CreateAuthorCommand;
use App\Model\Images\Application\Author\Command\Create\CreateAuthorCommandHandler;
use App\Model\Images\Application\Author\Command\Create\CreateAuthorForm;
use App\Model\Images\Application\Author\Command\Exceptions\NicknameIsAlreadyInUse;
use App\Model\User\Domain\Entity\User;
use App\Service\ErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CreateAuthor extends AbstractController
{
    public function __construct(private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/author/create', name: 'app_author_create')]
    public function create(Request $request, CreateAuthorCommandHandler $handler): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $command = new CreateAuthorCommand($user->getId()->getValue());

        $command->name = $user->getName()->getName();
        $command->surname = $user->getName()->getSurname();

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
            'form' => $form->createView()
        ]);
    }
}
