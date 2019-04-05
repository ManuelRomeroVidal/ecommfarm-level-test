<?php
namespace App\Service;

use App\Entity\User;
use App\Provider\Mailer\MailerProvider;

/**
 * NotificationService Class
 *
 * @author  Manuel Romero <manuelromerovidal@gmail.com>
 *
 */
class NotificationService
{
    private $mailerProvider;

    /*
     *
     */
    public function setService(MailerProvider $mailerProvider)
    {
        $this->mailerProvider = $mailerProvider;
    }

    /*
     *
     */
    public function getService()
    {
        return $this->mailerProvider;
    }

    /*
     *
     */
    public function notify(User $user, $message):bool
    {
        $userEmail = $user->getEmail();
        $provider = $this->mailerProvider->getProvider();
        return $provider->send($userEmail, $message);
    }
}