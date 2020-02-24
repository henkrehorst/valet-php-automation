<?php


namespace App\Service;


use App\Entity\PlatformUpdate;
use App\Entity\Update;
use App\Modules\Bintray\Service\BintrayService;
use App\Modules\Formula\Service\FormulaService;
use App\Modules\Github\Service\GithubService;
use App\Modules\Slack\Service\SlackService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Registry;

class UpdateFinishService
{
    private $entityManager;
    private $workFlows;
    private $formulaService;
    private $githubService;
    private $bintrayService;
    private $slackService;

    /**
     * UpdateFinishService constructor.
     * @param EntityManagerInterface $entityManager
     * @param Registry $workflows
     */
    public function __construct(EntityManagerInterface $entityManager,
                                Registry $workflows,
                                FormulaService $formulaService,
                                GithubService $githubService,
                                BintrayService $bintrayService,
                                SlackService $slackService)
    {
        $this->entityManager = $entityManager;
        $this->workFlows = $workflows;
        $this->formulaService = $formulaService;
        $this->githubService = $githubService;
        $this->bintrayService = $bintrayService;
        $this->slackService = $slackService;
    }

    /**
     * @param PlatformUpdate $platformUpdate
     * @param $bottleHash
     * @return PlatformUpdate
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function finishPlatformUpdate(PlatformUpdate $platformUpdate, $bottleHash)
    {
        //set new bottle hash in platform update
        $platformUpdate->setBottleHash($bottleHash);
        //set new status for platform update
        $workflow = $this->workFlows->get($platformUpdate, 'platform_update_process');
        if ($workflow->can($platformUpdate, 'finish')) {
            $workflow->apply($platformUpdate, 'finish');
        }
        //save platform update
        $this->entityManager->persist($platformUpdate);
        $this->entityManager->flush();

        return $platformUpdate;
    }

    /**
     * @param PlatformUpdate $platformUpdate
     * @return string
     */
    public function finishUpdate(PlatformUpdate $platformUpdate)
    {
        $parentUpdate = $platformUpdate->getParentUpdate();
        //check if all platform updates already finished
        if ($this->checkPlatformUpdates($parentUpdate)) {
            //update status of parent update
            $workflow = $this->workFlows->get($parentUpdate, 'update_process');
            $workflow->apply($parentUpdate, 'to_update_bottle_hash');
            $this->entityManager->persist($parentUpdate);
            $this->entityManager->flush();

            //update bottle hashes on github
            $content = $this->githubService->getFormulaContent($parentUpdate->getPhpVersion()->getMinorVersion(), $parentUpdate->getBranch());
            $content = $this->formulaService->updateBottleHashes($content, $parentUpdate);
            $this->githubService->updateFormulaFile($parentUpdate->getPhpVersion()->getMinorVersion(),
                $content,
                "Update bottle hashes of valet-php@{$parentUpdate->getPhpVersion()->getMinorVersion()}",
                $parentUpdate->getBranch());

            //publish update on bintray
            $this->bintrayService->publishPackage("php-{$parentUpdate->getPhpVersion()->getMinorVersion()}",
                "{$parentUpdate->getReleaseVersion()}_{$parentUpdate->getRevisionVersion()}");

            //create pull request
            $pullRequest = $this->githubService->createPullRequest($parentUpdate->getBranch(),
                "valet-php@{$parentUpdate->getPhpVersion()->getMinorVersion()} update {$parentUpdate->getReleaseVersion()}",
                "{$parentUpdate->getType()} for valet-php@{$parentUpdate->getPhpVersion()->getMinorVersion()}");

            if (getenv("APP_ENV" != "dev")) {
                //send message to slack
                $this->slackService->sendMessage(
                    "[Pull Request] valet-php@{$parentUpdate->getPhpVersion()->getMinorVersion()} update {$parentUpdate->getReleaseVersion()}\n" .
                    "{$parentUpdate->getType()} for valet-php@{$parentUpdate->getPhpVersion()->getMinorVersion()}" .
                    "{$pullRequest->getUrl()}");
            }

            //update status parent update
            $workflow = $this->workFlows->get($parentUpdate, 'update_process');
            $workflow->apply($parentUpdate, 'to_pull_request');
            $this->entityManager->persist($parentUpdate);
            $this->entityManager->flush();

            return "pull request for update published";
        } else {
            return "the update is not yet built for every platform";
        }
    }

    /**
     * @param Update $update
     * @return bool
     */
    private function checkPlatformUpdates(Update $update)
    {
        $platformUpdatesBuildFinished = true;
        $platformUpdates = $update->getPlatformUpdates();
        foreach ($platformUpdates as $platformUpdate) {
            $workflow = $this->workFlows->get($platformUpdate, 'platform_update_process');
            if ($workflow->can($platformUpdate, 'finish')) {
                $platformUpdatesBuildFinished = false;
            }
        }

        return $platformUpdatesBuildFinished;
    }
}