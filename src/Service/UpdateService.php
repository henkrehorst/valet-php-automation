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

    public function __construct(SetupService $setupService, UpdateCheckService $updateCheckService)
    {
        $this->setupService = $setupService;
        $this->updateCheckService = $updateCheckService;
    }

    public function init(SymfonyStyle $io = null)
    {
        //setup initial data for update process
        $this->setupService->setup($io);

        //check for php updates
        $this->updateCheckService->checkForUpdates($io);
    }
}