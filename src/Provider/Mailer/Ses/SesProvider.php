<?php

namespace App\Provider\Mailer\Ses;

use App\Provider\Mailer\MailerProviderInterface;
/**
 * SesProvider Class
 *
 * @author  Manuel Romero <manuelromerovidal@gmail.com>
 *
 */
class SesProvider implements MailerProviderInterface
{
    /*
     *Send message to email and return result
     */
    public function Send(String $email, String $message):bool
    {
        return false;
    }
}