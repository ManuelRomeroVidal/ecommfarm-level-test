<?php

namespace App\Provider;


/**
 * SmtpProvider Class
 *
 * @author  Manuel Romero <manuelromerovidal@gmail.com>
 *
 */
class SmtpProvider implements MailerProviderInterface
{
    /*
     *Send message to email and return result
     */
    public function Send(String $email, String $message):bool
    {
        return true;
    }
}