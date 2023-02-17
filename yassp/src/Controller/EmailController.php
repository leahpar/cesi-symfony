<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class EmailController extends AbstractController
{

    #[Route('/email', name:'email')]
    #[IsGranted('ROLE_ADMIN')]
    public function email(MailerInterface $mailer)
    {
        $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            //->html('<p>See Twig integration for better HTML integration!</p>')
            ->htmlTemplate('mail.html.twig', [
                //'var' => $var,
            ])
        ;
        $mailer->send($email);

        return new Response();
    }
}
