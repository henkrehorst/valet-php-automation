<?php


namespace App\Service;
/*
 * Service for starting the update process
 */

use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateService
{
    private $setupService;
    private $updateCheckService;
    private $updateCreateService;
    private $buildService;

    public function __construct(SetupService $setupService,
                                UpdateCheckService $updateCheckService,
                                UpdateCreateService $updateCreateService,
                                BuildService $buildService)
    {
        $this->setupService = $setupService;
        $this->updateCheckService = $updateCheckService;
        $this->updateCreateService = $updateCreateService;
        $this->buildService = $buildService;
    }

    public function init(SymfonyStyle $io = null)
    {
        //setup initial data for update process
        $this->setupService->setup($io);

        //get update information for php updates
        $updateInformation = $this->updateCheckService->checkForUpdates($io);

        //create build if the php versions have release updates
        if ($updateInformation["alreadyUpToDate"] === false) {
            //create updates
            $updates = $this->updateCreateService->createUpdates($updateInformation);

            //start build for updates
            $this->buildService->startBuild($updates);

        } else {
            //return success message no updates available
            $io->success("All the PHP versions already up to date");
        }


    }
}