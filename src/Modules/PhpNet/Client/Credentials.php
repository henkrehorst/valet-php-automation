<?php


namespace App\Modules\PhpNet\Client;

/**
 * Class Credentials
 * @package App\Modules\PhpNet\Client
 */
class Credentials
{
    const URLINDEX = 'PHP_NET_URL';

    /**
     * @return string
     */
    public function getUrl()
    {
        return getenv(self::URLINDEX);
    }
}