<?php

namespace App\Controller;

use App\Entity\User;
use App\Provider\Mailer\Smtp\SmtpProvider;
use App\Provider\Mailer\MailerProvider;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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

        // Get user from ID (Simnulate doctrine)
        $user = $professional = $this->getDoctrine()
            ->getRepository(User::class)
            ->getUserById($id);

        if(!$user) {
            return new Response(
                '<html><body>Usuario no encontrado</body></html>'
            );
        }

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
