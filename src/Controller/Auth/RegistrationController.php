<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Model\User\Application\Command\Signup\Confirm\ConfirmUserCommand;
use App\Model\User\Application\Command\Signup\Confirm\ConfirmUserCommandHandler;
use App\Model\User\Application\Command\Signup\Request\CreateUserCommand;
use App\Model\User\Application\Command\Signup\Request\CreateUserCommandHandler;
use App\Model\User\Application\Command\Signup\Request\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use App\Service\ErrorHandler;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

final class RegistrationController extends AbstractController
{
    public function __construct(private readonly ErrorHandler $errorHandler)
    {
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, CreateUserCommandHandler $handler): Response
    {
        $command = new CreateUserCommand();
        $form = $this->createForm(RegistrationFormType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);

                $this->addFlash('success', 'Check your email.');

                return $this->redirect('/');
            } catch (Exception $exception) {
                $this->errorHandler->handle($exception);
                $this->addFlash('error', $exception->getMessage());
            } catch (TransportExceptionInterface $e) {
                $this->errorHandler->handle($e);
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email/{token}', name: 'app_verify_email')]
    public function verifyUserEmail(string $token, Request $request, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, ConfirmUserCommandHandler $handler): Response
    {
        try {
            $command = new ConfirmUserCommand($token);
            $handler->handle($command);

            return $userAuthenticator->authenticateUser(
                $this->getUser(),
                $authenticator,
                $request
            );
        } catch (Exception $exception) {
            $this->addFlash('error', $exception->getMessage());

            $this->errorHandler->handle($exception);

            return $this->redirectToRoute('app_register');
        }
    }
}
