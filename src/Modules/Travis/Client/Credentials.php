<?php


namespace App\Modules\Travis\Client;


class Credentials
{
    const TOKEN_INDEX = "TRAVIS_TOKEN";
    const URL_INDEX = "TRAVIS_URL";
    const USER_INDEX = "TRAVIS_USER";
    const PROJECT_INDEX = "TRAVIS_PROJECT";
    const OS_INDEX = "TRAVIS_SUPPORTED_OS";


    public function getToken()
    {
        return getenv(self::TOKEN_INDEX);
    }

    public function getUrl()
    {
        return getenv(self::URL_INDEX);
    }

    public function getUser()
    {
        return getenv(self::USER_INDEX);
    }

    public function getProject()
    {
        return getenv(self::PROJECT_INDEX);
    }
}