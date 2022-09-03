<?php

declare(strict_types=1);

namespace App\Model\User\Application\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final class SignupSender
{
    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly string          $from,
        private readonly string          $name
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(string $email, string $token): void
    {
        $message = (new TemplatedEmail())
            ->from(new Address($this->from, $this->name))
            ->to($email)
            ->subject('Please Confirm your Email')
            ->htmlTemplate('registration/confirmation_email.html.twig')
            ->context(['token' => $token]);

        file_put_contents('mails', $token, LOCK_EX); // TODO: Удалить

        $this->mailer->send($message);
    }
}
