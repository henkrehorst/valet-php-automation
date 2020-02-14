<?php


namespace App\Service;


use App\Entity\PlatformUpdate;
use App\Entity\Update;
use App\Modules\Formula\Service\FormulaService;
use App\Modules\Github\Service\GithubService;
use App\Modules\Travis\Service\TravisService;
use App\Repository\PlatformRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Workflow\Registry;

/**
 * Class BuildService
 * @package App\Service
 *
 */
class BuildService
{
    private $githubService;
    private $formulaService;
    private $platformRepository;
    private $entityManager;
    private $travisService;
    private $workFlows;

    public function __construct(GithubService $githubService, FormulaService $formulaService,
                                PlatformRepository $platformRepository, EntityManagerInterface $entityManager,
                                TravisService $travisService, Registry $workFlows)
    {
        $this->githubService = $githubService;
        $this->formulaService = $formulaService;
        $this->platformRepository = $platformRepository;
        $this->entityManager = $entityManager;
        $this->travisService = $travisService;
        $this->workFlows = $workFlows;
    }

    /**
     * @param Update[] $updates
     */
    public function startBuild(array $updates, SymfonyStyle $io = null)
    {
        if ($io) $io->title("Start build process");

        foreach ($updates as $update) {
            if ($io) $io->note("Prepare update for PHP {$update->getPhpVersion()->getMinorVersion()}");
            //prepare update
            $this->prepare($update);

            //update success message
            if ($io) $io->success("Update successfully prepared");

            if ($io) $io->note("Create platform updates for update");
            //create platform updates for platforms
            $platformUpdates = $this->createPlatformUpdates($update);
            if ($io) $io->success("Platform updates successfully created");

            //push builds for update to CiCd
            $this->pushUpdateToCiCd($update, $platformUpdates);

            //update the status of updates
            $this->updateStatus($update, $platformUpdates);
        }
    }

    private function prepare(Update $update)
    {
        //create a new update branch on github
        $this->githubService->createNewBranch($update->getBranch());

        //if it is a release update, update the php release version and package hash
        if ($update->getType() == "releaseUpdate") {
            //update php source in formula content
            $formulaContent = $this->formulaService->updatePhpSource(
                $this->githubService->getFormulaContent($update->getPhpVersion()->getMinorVersion(),
                    $update->getBranch()),
                $update->getReleaseVersion(),
                $update->getPackageHash()
            );
            $formulaContent = $this->formulaService->updateRevisionVersion($formulaContent, $update);

            //update formula content on github
            $this->githubService->updateFormulaFile($update->getPhpVersion()->getMinorVersion(),
                $formulaContent,
                "Update source to {$update->getReleaseVersion()} and package hash",
                $update->getBranch()
            );
        }
    }

    /**
     * @param Update $update
     * @return PlatformUpdate[]
     */
    private function createPlatformUpdates(Update $update)
    {
        $platformUpdates = [];

        //get supported platforms
        $platforms = $this->platformRepository->getSupportedPlatforms();

        foreach ($platforms as $platform) {
            //create new platform update
            $platformUpdate = new PlatformUpdate();
            $platformUpdate->setPlatform($platform);
            $platformUpdate->setParentUpdate($update);

            $this->entityManager->persist($platformUpdate);

            $platformUpdates[] = $platformUpdate;
        }

        //save platform updates in DB
        $this->entityManager->flush();

        //return platform updates
        return $platformUpdates;
    }

    /**
     * @param Update $update
     * @param PlatformUpdate[] $platformUpdates
     */
    private function pushUpdateToCiCd(Update $update, array $platformUpdates)
    {
        $buildsForTravis = [];
        $buildsForAzurePipelines = [];

        //sort platform updates by ci/cd
        foreach ($platformUpdates as $platformUpdate) {
            if ($platformUpdate->getPlatform()->getCiCd() === "travis") {
                $buildsForTravis[] = $platformUpdate;
            } elseif ($platformUpdate->getPlatform()->getCiCd() === "azurePipelines") {
                $buildsForAzurePipelines[] = $platformUpdate;
            }
        }

        //apply jobs for platform updates to ci/cd's
        $this->travisService->triggerBuilds($buildsForTravis, $update, "valet php update {$update->getReleaseVersion()}");

    }

    /**
     * @param Update $update
     * @param PlatformUpdate[] $platformUpdate
     */
    public function updateStatus(Update $update, array $platformUpdates)
    {
        //change platform update status to build
        foreach ($platformUpdates as $platformUpdate) {
            $workflow = $this->workFlows->get($platformUpdate, 'platform_update_process');
            $workflow->apply($platformUpdate, 'to_build');
        }

        //change parent update status to build
        $workflow = $this->workFlows->get($update, 'update_process');
        $workflow->apply($update, 'to_build');
        //save status in database
        $this->entityManager->flush();
    }
}