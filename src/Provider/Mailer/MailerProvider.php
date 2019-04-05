<?php
namespace App\Provider\Mailer;

/**
 * MailerProvider Class
 *
 * @author  Manuel Romero <manuelromerovidal@gmail.com>
 *
 */
class MailerProvider
{
    private $provider;

    /**
     * Set provider
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get provider
     */
    public function getProvider()
    {
        return $this->provider;
    }
}
