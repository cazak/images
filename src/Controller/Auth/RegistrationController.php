<?php

declare(strict_types=1);

namespace App\Controller\Auth;

use App\Form\RegistrationFormType;
use App\Model\User\Application\Command\Signup\Confirm\ConfirmUserCommand;
use App\Model\User\Application\Command\Signup\Confirm\ConfirmUserCommandHandler;
use App\Model\User\Application\Command\Signup\Request\CreateUserCommand;
use App\Model\User\Application\Command\Signup\Request\CreateUserCommandHandler;
use App\Security\LoginFormAuthenticator;
use App\Service\ErrorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
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
            } catch (\Exception $exception) {
                $this->errorHandler->handle($exception);
                $this->addFlash('error', $exception->getMessage());
            }
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, ConfirmUserCommandHandler $handler): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $command = new ConfirmUserCommand();
            $command->uri = $request->getUri();
            $command->user = $this->getUser();
            $handler->handle($command);

            return $userAuthenticator->authenticateUser(
                $this->getUser(),
                $authenticator,
                $request
            );
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            $this->errorHandler->handle($exception);

            return $this->redirectToRoute('app_register');
        } catch (\Exception $exception) {
            $this->addFlash('error', $exception->getMessage());

            $this->errorHandler->handle($exception);

            return $this->redirectToRoute('app_register');
        }
    }
}
