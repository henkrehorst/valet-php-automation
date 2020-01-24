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
    const BRANCH_INDEX = 'HOMEBREW_PHP_BRANCH';

    /**
     * @return string
     */
    public function getRepo()
    {
        return getenv(self::REPO_INDEX);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return getenv(self::USERNAME_INDEX);
    }

    /**
     * @return string
     */
    public function getBranch()
    {
        return getenv(self::BRANCH_INDEX);
    }
}