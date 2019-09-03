<?php


namespace App\Service;

use App\Entity\PhpVersion;
use App\Entity\Platform;
use App\Modules\Github\Service\GithubService;
use App\Repository\PhpVersionRepository;
use App\Repository\PlatformRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * This service add important data to run the php update cron
 *
 * Class SetupService
 * @package App\Service
 */
class SetupService
{
    private $platformRepository;
    private $phpVersionRepository;
    private $entityManager;
    private $githubService;

    public function __construct(
        PlatformRepository $platformRepository,
        PhpVersionRepository $phpVersionRepository,
        EntityManagerInterface $entityManager,
        GithubService $githubService)
    {
        $this->platformRepository = $platformRepository;
        $this->phpVersionRepository = $phpVersionRepository;
        $this->entityManager = $entityManager;
        $this->githubService = $githubService;
    }

    public function setup(SymfonyStyle $io = null)
    {
        //display title on console
        if($io) $io->title("Setup process");

        //check if php versions model no data exists
        if (empty($this->phpVersionRepository->findAll())) {
            //setup php version data, first get all php packages from github
            foreach ($this->githubService->getFilesFromFormulaFolder() as $file){
                //get php version from formula
                $version = $this->githubService->getPhpVersionFromFile($file['name']);

                $phpVersion = new PhpVersion();
                $phpVersion->setMinorVersion(substr($version, 0, 3));
                $phpVersion->setCurrentReleaseVersion($version);

                //set status php version lower than 7.1 end of line
                if(substr($version, 0, 3) < 7.1){
                    $phpVersion->setStatus("EOL");
                }

                $this->entityManager->persist($phpVersion);
            }

            //save all php version in database
            $this->entityManager->flush();

            //display success message on command line
            if ($io) $io->success("php version data successfully created");
        } else {
            //display warning data already available
            if ($io) $io->success("php version data is already available!");
        }

        //check if platform model no data exists
        if (empty($this->platformRepository->findAll())) {
            //setup mojave platform
            $plaform = new Platform();
            $plaform->setName('mojave');
            $plaform->setImageName('xcode10.2');
            $this->entityManager->persist($plaform);

            //setup high_sierra platform
            $plaform = new Platform();
            $plaform->setName('high_sierra');
            $plaform->setImageName('xcode10');
            $this->entityManager->persist($plaform);


            //setup sierra platform
            $plaform = new Platform();
            $plaform->setName('sierra');
            $plaform->setImageName('xcode9.2');
            $this->entityManager->persist($plaform);

            //save platforms
            $this->entityManager->flush();


            //display success message on command line
            if ($io) $io->success("platform data successfully created");
        } else {
            //display warning data already available
            if ($io) $io->success("platform data is already available!");
        }
    }
}