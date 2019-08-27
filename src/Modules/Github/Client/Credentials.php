<?php


namespace App\Modules\Github\Client;


class Credentials
{
    const SECRET_INDEX = 'GITHUB_SECRET';
    const USERNAME_INDEX = 'GITHUB_USERNAME';
    const AUTH_METHOD_INDEX = 'GITHUB_AUTH_METHOD';
    const NAME_INDEX = 'GITHUB_COMMIT_NAME';
    const EMAIL_INDEX = 'GITHUB_COMMIT_EMAIL';

    public function getSecret()
    {
        return getenv(self::SECRET_INDEX);
    }

    public function getUsername()
    {
        return getenv(self::USERNAME_INDEX);
    }

    public function getAuthMethod()
    {
        return getenv(self::AUTH_METHOD_INDEX);
    }

    /**
     * @return array
     */
    public function getCommitter()
    {
        return [
            'name' => getenv(self::NAME_INDEX),
            'email' => getenv(self::EMAIL_INDEX)
        ];
    }
}