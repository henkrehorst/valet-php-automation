<?php


namespace App\Client;

/**
 * Client for getting all important credentials for the brew tap
 * Class GlobalCredentials
 * @package App\Client
 */

class GlobalCredentials
{
    const REPO_INDEX = 'HOMEBREW_PHP_REPO';
    const USERNAME_INDEX = 'HOMEBREW_PHP_USERNAME';

    public function getRepo()
    {
        return getenv(self::REPO_INDEX);
    }

    public function getUsername()
    {
        return getenv(self::USERNAME_INDEX);
    }
}