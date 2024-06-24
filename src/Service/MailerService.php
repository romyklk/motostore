<?php

namespace App\Service;


use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class MailerService
{
    public function __construct(
        #[Autowire('%admin_email%')] private string $adminEmail,
        private readonly MailerInterface $mailer
    ) {
    }


    public function sendEstimate(string $to, $ad, string $customerName): void
    {
        $email = (new TemplatedEmail())
            ->from($this->adminEmail)
            ->to($to)
            ->subject('Réception de votre demande de devis')
            ->htmlTemplate('emails/estimate.html.twig')
            ->context(
                [
                    'ad' => $ad,
                    'customerName' => $customerName,
                    'customerEmail' => $to,
                ]
            );

        $this->mailer->send($email);
    }

    public function sendEstimateToAdmin(string $from, string $customerName, string $customerEmail, array $formData,$ad): void
    {
        // Email à l'administrateur
        $adminEmail = (new TemplatedEmail())
            ->from($this->adminEmail)
            ->to($this->adminEmail)
            ->replyTo($from)
            ->subject('Demande de devis')
            ->htmlTemplate('emails/estimate-admin.html.twig')
            ->context([
                'name' => $customerName,
            'customerEmail' => $customerEmail,
                'message' => $formData['message'],
                'phone' => $formData['phone'],
                'ad' => $ad,
            ]);
        $this->mailer->send($adminEmail);
    }


    public function sendMailToAdmin(string $from, string $customerName, string $customerEmail, array $formData): void
    {
        // Email à l'administrateur
        $adminEmail = (new TemplatedEmail())
            ->from($this->adminEmail)
            ->to($this->adminEmail)
            ->replyTo($from)
            ->subject('Demande de contact')
            ->htmlTemplate('emails/contact-us.html.twig')
            ->context([
                'name' => $customerName,
                'customerEmailAdmin' => $customerEmail,
                'message' => $formData['message'],
                'phone' => $formData['phone'],
            ]);
        $this->mailer->send($adminEmail);

        // Email de confirmation à l'expéditeur
        $confirmationEmail = (new TemplatedEmail())
            ->from($this->adminEmail)
            ->to($customerEmail)
            ->replyTo($this->adminEmail)
            ->subject('Confirmation de votre demande de contact')
            ->htmlTemplate('emails/contact-confirmation.html.twig')
            ->context([
                'name' => $customerName,
                'customerEmail' => $customerEmail,
                'message' => $formData['message'],
                'phone' => $formData['phone'],
            ]);
        $this->mailer->send($confirmationEmail);
    }
}
