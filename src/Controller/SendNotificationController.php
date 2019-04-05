<?php

namespace App\Controller;

use App\Entity\User;
use App\Provider\Mailer\Smtp\SmtpProvider;
use App\Provider\Mailer\MailerProvider;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SendNotificationController Class
 *
 * @author  Manuel Romero <manuelromerovidal@gmail.com>
 *
 */
class SendNotificationController extends AbstractController
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @Route("/users/send_notification/{id}", name="send_notification")
     */
    public function sendNotification($id, SmtpProvider $smtpProvider, MailerProvider $mailerProvider)
    {
        //default message
        $message = "Mensaje que se ha enviado";

        // Get user from ID
        $user = new User();

        // Set provider (smtp) to mailerProvider
        $mailerProvider->setProvider($smtpProvider);

        // Set the service (mailerProvider) to notificationService
        $this->notificationService->setService($mailerProvider);

        // Send notification (message) to User
        $result = $this->notificationService->notify($user, $message);

        $responseData = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'message' => $message,
            'result' => $result,
        ];
        $response = new JsonResponse($responseData);

        return $response;
    }
}
