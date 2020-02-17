<?php


namespace App\Service;


use App\Repository\PhpVersionRepository;
use Symfony\Component\Console\Style\SymfonyStyle;

class RebuildService
{
    private $setupService;
    private $buildService;
    private $phpVersionRepository;
    private $updateCreateService;
    private $rebuildCreateService;

    public function __construct(SetupService $setupService,
                                BuildService $buildService,
                                PhpVersionRepository $phpVersionRepository,
                                UpdateCreateService $updateCreateService,
                                RebuildCreateService $rebuildCreateService)
    {
        $this->setupService = $setupService;
        $this->buildService = $buildService;
        $this->phpVersionRepository = $phpVersionRepository;
        $this->updateCreateService = $updateCreateService;
        $this->rebuildCreateService = $rebuildCreateService;

    }

    public function init($version, SymfonyStyle $io = null)
    {
        //setup initial data for update process
        $this->setupService->setup($io);

        if($io) $io->title('Rebuild process');

        //check php version exists for rebuild
        $phpVersion = $this->phpVersionRepository->getPhpVersionByVersion($version);
        $this->updateCreateService->generateRevisionVersion($phpVersion->getMinorVersion());

        if ($phpVersion !== null) {
            if ($io) $io->success("Found PHP version in brewtap, start rebuild process!");
            $updates = $this->rebuildCreateService->createRebuild($phpVersion, $io);
            $this->buildService->startBuild($updates, $io);
        }else{
            if ($io) $io->error("PHP version not found in brewtap!");
        }
    }
}