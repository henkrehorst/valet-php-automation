<?php


namespace App\Modules\AzureDevOps\Client;


class Credentials
{
    const USERNAME_INDEX = "AZURE_DEVOPS_USERNAME";
    const ACCESS_TOKEN_INDEX = "AZURE_DEVOPS_ACCESS_TOKEN";
    const API_VERSION_INDEX = "AZURE_DEVOPS_API_VERSION";
    const ORGANIZATION_INDEX = "AZURE_DEVOPS_ORGANIZATION";
    const PROJECT_INDEX = "AZURE_DEVOPS_PROJECT";
    const URL_INDEX = "AZURE_DEVOPS_URL";


    public function getUsername()
    {
        return getenv(self::USERNAME_INDEX);
    }

    public function getAccessToken()
    {
        return getenv(self::ACCESS_TOKEN_INDEX);
    }

    public function getApiVersion()
    {
        return getenv(self::API_VERSION_INDEX);
    }

    public function getOrganization()
    {
        return getenv(self::ORGANIZATION_INDEX);
    }

    public function getProject()
    {
        return getenv(self::PROJECT_INDEX);
    }

    public function getUrl()
    {
        return getenv(self::URL_INDEX);
    }


}