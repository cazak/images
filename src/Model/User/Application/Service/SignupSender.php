<?php

declare(strict_types=1);

namespace App\Model\User\Application\Service;

use App\Model\User\Domain\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

final class SignupSender
{
    public function __construct(
        private readonly VerifyEmailHelperInterface $verifyEmailHelper,
        private readonly MailerInterface            $mailer,
        private readonly string                     $from,
        private readonly string                     $name
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(User $user): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($this->from, $this->name))
            ->to($user->getEmail()->getValue())
            ->subject('Please Confirm your Email')
            ->htmlTemplate('registration/confirmation_email.html.twig');

        $this->sendEmailConfirmation(
            'app_verify_email',
            $user->getId()->getValue(),
            $user->getEmail()->getValue(),
            $email
        );
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmailConfirmation(string $verifyEmailRouteName, string $id, string $email, TemplatedEmail $templatedEmail): void
    {
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $id,
            $email
        );

        file_put_contents('mails', $signatureComponents->getSignedUrl(), LOCK_EX); // TODO: Удалить

        $context = $templatedEmail->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $templatedEmail->context($context);

        $this->mailer->send($templatedEmail);
    }
}
