<?php


namespace App\Service;

/*
 * Service for checking if all php version in the brewtap up to date
 */

use App\Modules\PhpNet\Service\PhpNetService;
use App\Repository\PhpVersionRepository;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateCheckService
{
    private $phpNetService;
    private $phpVersionRepository;

    public function __construct(PhpNetService $phpNetService, PhpVersionRepository $phpVersionRepository)
    {
        $this->phpNetService = $phpNetService;
        $this->phpVersionRepository = $phpVersionRepository;
    }

    public function checkForUpdates(SymfonyStyle $io = null)
    {
        //create array with update information
        $updateArray["alreadyUpToDate"] = true;

        //display title on console
        if ($io) $io->title("Checking for updates");


        //get php versions and check the release is up to data
        foreach ($this->phpVersionRepository->getSupportedOrEolPhpVersions() as $phpVersion) {
            $newReleaseVersion = $this->phpNetService->getLatestReleaseVersion($phpVersion->getMinorVersion());

            if ($newReleaseVersion === $phpVersion->getCurrentReleaseVersion()) {
                if ($io) $io->success("PHP " . $phpVersion->getMinorVersion() . " already up to date");
            } else {
                $updateArray["alreadyUpToDate"] = false;

                //push version update to update array
                $updateArray["updates"][$phpVersion->getMinorVersion()]["releaseVersion"] = $newReleaseVersion;
                $updateArray["updates"][$phpVersion->getMinorVersion()]["packageHash"] = $this->phpNetService->getPackageHash($newReleaseVersion);
                $updateArray["updates"][$phpVersion->getMinorVersion()]["phpVersion"] = $phpVersion;

                if ($io) $io->warning("PHP " . $phpVersion->getMinorVersion() . " has a new release version");
            }
        }

        dd($updateArray);
    }
}