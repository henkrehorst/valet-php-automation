<?php


namespace App\Modules\Bintray\Client;


class Credentials
{
    const AUTOMATION_ENDPOINT_INDEX = "BINTRAY_AUTOMATION_ENDPOINT";
    const PACKAGE_REPOSITORY_INDEX = "BINTRAY_PACKAGE_REPOSITORY";
    const API_TOKEN_INDEX = "BINTRAY_API_TOKEN";
    const USERNAME_INDEX = "BINTRAY_USERNAME";
    const URL_INDEX = "BINTRAY_URL";

    public function getAutomationEndpoint()
    {
        return getenv(self::AUTOMATION_ENDPOINT_INDEX);
    }

    public function getPackageRepository()
    {
        return getenv(self::PACKAGE_REPOSITORY_INDEX);
    }

    public function getApiToken()
    {
        return getenv(self::API_TOKEN_INDEX);
    }

    public function getUsername()
    {
        return getenv(self::USERNAME_INDEX);
    }

    public function getUrl()
    {
        return getenv(self::URL_INDEX);
    }
}