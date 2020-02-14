<?php


namespace App\Service;


use App\Entity\PlatformUpdate;
use App\Entity\Update;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Registry;

class UpdateFinishService
{
    private $entityManager;
    private $workFlows;

    /**
     * UpdateFinishService constructor.
     * @param EntityManagerInterface $entityManager
     * @param Registry $workflows
     */
    public function __construct(EntityManagerInterface $entityManager, Registry $workflows)
    {
        $this->entityManager = $entityManager;
        $this->workFlows = $workflows;
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
        if($workflow->can($platformUpdate, 'finish')) {
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
        //check if all platform updates already finished
        if($this->checkPlatformUpdates($platformUpdate->getParentUpdate())){
            //TODO-HENK update bottle hashes on github

            //TODO-HENK publish update on bintray

            //TODO-HENK create pull request


            return "pull request for update published";
        }else{
            return "the update is not yet built for every platform";
        }
    }

    /**
     * @param Update $update
     * @return bool
     */
    private function checkPlatformUpdates(Update $update){
        $platformUpdatesBuildFinished = true;
        $platformUpdates = $update->getPlatformUpdates();
        foreach ($platformUpdates as $platformUpdate) {
            $workflow = $this->workFlows->get($platformUpdate, 'platform_update_process');
            if($workflow->can($platformUpdate, 'finish')){
                $platformUpdatesBuildFinished = false;
            }
        }

        return $platformUpdatesBuildFinished;
    }
}