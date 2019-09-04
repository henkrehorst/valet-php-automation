<?php


namespace App\Service;

/**
 * Service for creating updates
 */

use App\Entity\Update;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateCreateService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createUpdates(array $updateInformation, SymfonyStyle $io = null)
    {
        $updates = [];

        foreach ($updateInformation["updates"] as $updateInfo) {
            $update = new Update();
            $update->setReleaseVersion($updateInfo["releaseVersion"]);
            $update->setPackageHash($updateInfo["packageHash"]);
            $update->setBranch("update-test/" . $updateInfo['releaseVersion'] . "@" . time());
            $update->setPhpVersion($updateInfo["phpVersion"]);
            $update->setCreatedAt(new \DateTime("now"));

            $this->entityManager->persist($update);
            $updates[] = $update;
        }

        //save all updates to database
        $this->entityManager->flush();

        return $updates;
    }
}