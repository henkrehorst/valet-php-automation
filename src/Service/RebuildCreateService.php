<?php


namespace App\Service;


use App\Entity\PhpVersion;
use App\Modules\PhpNet\Service\PhpNetService;
use App\Repository\PhpVersionRepository;
use Symfony\Component\Console\Style\SymfonyStyle;

class RebuildCreateService
{
    private $phpNetService;
    private $phpVersionRepository;
    private $updateCreateService;

    public function __construct(PhpNetService $phpNetService, PhpVersionRepository $phpVersionRepository, UpdateCreateService $updateCreateService)
    {
        $this->phpNetService = $phpNetService;
        $this->phpVersionRepository = $phpVersionRepository;
        $this->updateCreateService = $updateCreateService;
    }

    public function createRebuild(PhpVersion $phpVersion, SymfonyStyle $io = null)
    {
        //create array with update information
        $updateArray["alreadyUpToDate"] = false;

        //display title on console
        if ($io) $io->title("Create rebuild update");

        $newReleaseVersion = $this->phpNetService->getLatestReleaseVersion($phpVersion->getMinorVersion());

        //push version update to update array
        $updateArray["updates"][$phpVersion->getMinorVersion()]["releaseVersion"] = $newReleaseVersion;
        $updateArray["updates"][$phpVersion->getMinorVersion()]["packageHash"] = $this->phpNetService->getPackageHash($newReleaseVersion);
        $updateArray["updates"][$phpVersion->getMinorVersion()]["phpVersion"] = $phpVersion;


        return $this->updateCreateService->createUpdates($updateArray, null, true);
    }
}