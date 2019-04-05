<?php
namespace App\Service;

use App\Entity\User;
use App\Provider\MailerProvider;

class NotificationService
{
    private $usedService;

    /*
     *
     */
    public function setService(MailerProvider $usedService)
    {
        $this->usedService = $usedService;
    }

    /*
     *
     */
    public function getService()
    {
        return $this->usedService;
    }

    /*
     *
     */
    public function notify(User $user, $message):bool
    {
        $userEmail = $user->getEmail();
        return $this->usedService->send($userEmail, $message);
    }
}