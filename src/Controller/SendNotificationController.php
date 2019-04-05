<?php

namespace App\Controller;

use App\Entity\User;
use App\Provider\SmtpProvider;
use App\Provider\MailerProvider;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SendNotificationController extends AbstractController
{
    private $notificationService;

    public function __construct(NotificationService $notificationService, SmtpProvider $smtpProvider)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @Route("/users/send_notification/{id}", name="send_notification")
     */
    public function sendNotification($id)
    {
        $user = new User();
        $smtpProvider = new SmtpProvider();
        $mailerProvider = new MailerProvider();
        $mailerProvider->setProvider($smtpProvider);

        $this->notificationService->setService($mailerProvider);

        $message = "Mensaje que se ha enviado";

        $this->notificationService->notify($user, $message);
        /*
        return $this->render('send_notification/index.html.twig', [
            'controller_name' => 'SendNotificationController',
        ]);
        */
    }
}
