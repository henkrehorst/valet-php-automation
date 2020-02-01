<?php


namespace App\Modules\Bintray\Client;


class Credentials
{
    const AUTOMATION_ENDPOINT = "BINTRAY_AUTOMATION_ENDPOINT";
    const PACKAGE_REPOSITORY = "BINTRAY_PACKAGE_REPOSITORY";

    public function getAutomationEndpoint()
    {
        return getenv(self::AUTOMATION_ENDPOINT);
    }

    public function getPackageRepository()
    {
        return getenv(self::PACKAGE_REPOSITORY);
    }
}