<?php


namespace App\Service;

/**
 * Service for creating updates
 */

use App\Entity\Update;
use App\Repository\UpdateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateCreateService
{
    private $entityManager;
    private $updateRepository;

    public function __construct(EntityManagerInterface $entityManager, UpdateRepository $updateRepository)
    {
        $this->entityManager = $entityManager;
        $this->updateRepository = $updateRepository;
    }

    public function createUpdates(array $updateInformation, SymfonyStyle $io = null, $rebuild = false)
    {
        $updates = [];

        foreach ($updateInformation["updates"] as $updateInfo) {
            $update = new Update();
            $update->setReleaseVersion($updateInfo["releaseVersion"]);
            $update->setPackageHash($updateInfo["packageHash"]);

            if ($rebuild) {
                $update->setBranch(getenv('REBUILD_PREFIX_BRANCH') . "/" . $updateInfo['releaseVersion'] . "@" . time());
                $update->setType("rebuild");
                $update->setRevisionVersion($this->generateRevisionVersion($update->getReleaseVersion()));
            } else {
                $update->setBranch(getenv('UPDATE_PREFIX_BRANCH') . "/" . $updateInfo['releaseVersion'] . "@" . time());
            }

            $update->setPhpVersion($updateInfo["phpVersion"]);
            $update->setCreatedAt(new \DateTime("now"));

            $this->entityManager->persist($update);
            $updates[] = $update;
        }

        //save all updates to database
        $this->entityManager->flush();

        return $updates;
    }

    /**
     * @param $releaseVersion
     * @return int
     */
    public function generateRevisionVersion($releaseVersion)
    {
        // get latest revision version
        $revisionVersion = $this->updateRepository->getLatestRevisionVersion($releaseVersion);
        if ($revisionVersion !== null) {
            // increment revision version by 1
            return $revisionVersion['revisionVersion'] + 1;
        }

        return 0;
    }
}