<?php
namespace App\Provider;


class MailerProvider
{
    private $provider;

    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    public function getProvider()
    {
        return $this->provider;
    }
}
