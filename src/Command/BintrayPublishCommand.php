<?php

namespace App\Command;

use App\Modules\Bintray\Service\BintrayService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BintrayPublishCommand extends Command
{
    private $bintayService;
    protected static $defaultName = 'bintray:publish';

    public function __construct(BintrayService $bintrayService, string $name = null)
    {
        $this->bintayService = $bintrayService;
        parent::__construct($name);
    }


    protected function configure()
    {
        $this
            ->setDescription('Publish new package version on bintray')
            ->addArgument('package', InputArgument::OPTIONAL, 'Package name')
            ->addArgument('packageVersion', InputArgument::OPTIONAL, 'Version of the package');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $package = $input->getArgument('package');
        $packageVersion = $input->getArgument('packageVersion');
        $result = $this->bintayService->publishPackage($package, $packageVersion);
        // TODO-HENK add later better result output
        $io->note("Result:");
        $io->text($result);
        return 0;
    }
}
