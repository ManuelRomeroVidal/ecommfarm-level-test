<?php

namespace App\Provider;

/**
 * MailerProviderInterface interface
 *
 * @author  Manuel Romero <manuelromerovidal@gmail.com>
 *
 */
interface MailerProviderInterface
{
    public function send(string $email, string $message):bool;
}