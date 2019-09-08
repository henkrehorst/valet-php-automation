<?php


namespace App\Modules\Travis\Service;


use App\Entity\PlatformUpdate;
use App\Entity\Update;
use App\Modules\Travis\Handler\TravisHandler;
use App\Modules\Travis\Model\BuildRequest;

class TravisService
{
    private $travisHandler;

    public function __construct(TravisHandler $travisHandler)
    {
        $this->travisHandler = $travisHandler;
    }

    /**
     * @param PlatformUpdate[] $platformUpdates
     * @param Update $update
     * @param string $message
     */
    public function triggerBuilds(array $platformUpdates, Update $update, string $message)
    {
        //create new build request format
        $buildRequest = new BuildRequest($update->getBranch(), $message);

        //create config for build request
        foreach ($platformUpdates as $platformUpdate) {
            $buildRequest->getConfig()->setOs($platformUpdate->getPlatform()->getOs());
            //set image
            $buildRequest->getConfig()->setOsxImage($platformUpdate->getPlatform()->getImageName());
            //create stage for platform update
            $buildRequest->getConfig()->setStage(
                "PHP {$platformUpdate->getParentUpdate()->getPhpVersion()->getMinorVersion()}",
                $platformUpdate->getPlatform()->getImageName(),
                [
                    "PHPV={$platformUpdate->getParentUpdate()->getPhpVersion()->getMinorVersion()}",
                    "OS={$platformUpdate->getPlatform()->getName()}"
                ]);
        }


        //trigger build on travis
        $response = $this->travisHandler->runBuild($this->travisHandler->getProject()->getProjectId(), $buildRequest);

        dd($response);
    }
}