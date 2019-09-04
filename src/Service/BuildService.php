<?php


namespace App\Service;


use App\Entity\Update;
use App\Modules\Formula\Service\FormulaService;
use App\Modules\Github\Service\GithubService;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class BuildService
 * @package App\Service
 */
class BuildService
{
    private $githubService;
    private $formulaService;

    public function __construct(GithubService $githubService, FormulaService $formulaService)
    {
        $this->githubService = $githubService;
        $this->formulaService = $formulaService;
    }

    /**
     * @param Update[] $updates
     */
    public function startBuild(array $updates, SymfonyStyle $io = null)
    {
        if ($io) $io->title("Start build process");

        foreach ($updates as $update) {
            $io->note("Prepare update for PHP {$update->getPhpVersion()->getMinorVersion()}");
            //prepare update
            $this->prepare($update);

            $io->success("Update successfully prepared");
        }


        dd($updates);
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

            //update formula content on github
            $this->githubService->updateFormulaFile($update->getPhpVersion()->getMinorVersion(),
                $formulaContent,
                "Update source to {$update->getReleaseVersion()} and package hash",
                $update->getBranch()
            );
        }
    }

    private function createPlatformUpdates(Update $update)
    {

    }

    private function pushBuildToCiCd(){

    }
}