<?php


namespace App\Modules\AzureDevOps\Service;


use App\Entity\PlatformUpdate;
use App\Entity\Update;
use App\Modules\AzureDevOps\Handler\AzureDevOpsHandler;
use App\Modules\AzureDevOps\Model\BuildConfig;
use App\Modules\Bintray\Client\Credentials;

class AzureDevOpsService
{
    private $azureDevOpsHandler;
    private $bintrayCredentials;

    public function __construct(AzureDevOpsHandler $azureDevOpsHandler, Credentials $bintrayCredentials)
    {
        $this->azureDevOpsHandler = $azureDevOpsHandler;
        $this->bintrayCredentials = $bintrayCredentials;
    }

    /**
     * @param PlatformUpdate[] $platformUpdates
     * @param Update $update
     * @param string $message
     */
    public function triggerBuilds(array $platformUpdates, Update $update, string $message)
    {
        //create new build request format
        $buildRequest = new BuildConfig($update->getBranch());

        $buildRequest->setVariables([
            "PHPV" => $update->getPhpVersion()->getMinorVersion(),
            "PACKAGE_REPOSITORY" => $this->bintrayCredentials->getPackageRepository(),
            "BUILD_VERSION" => "{$update->getReleaseVersion()}_{$update->getRevisionVersion()}",
            "AUTOMATION_ENDPOINT" => $this->bintrayCredentials->getAutomationEndpoint(),
            "apiCall" => true
        ]);

        //add update id variables
        foreach ($platformUpdates as $platformUpdate) {
            $buildRequest->setUpdateIdVariable($platformUpdate->getId(), $platformUpdate->getPlatform()->getName());
        }

        //trigger pipeline on azure
        $response = $this->azureDevOpsHandler->triggerPipeline($buildRequest->getJson());
    }
}