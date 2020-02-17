<?php

namespace App\Command;

use App\Service\RebuildService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RebuildPhpVersionCommand extends Command
{
    protected static $defaultName = 'rebuild:php-version';
    private $rebuildService;

    public function __construct(RebuildService $rebuildService, string $name = null)
    {
        $this->rebuildService = $rebuildService;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Rebuild a specif php version')
            ->addArgument('version', InputArgument::REQUIRED, 'PHP version of the rebuild')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $phpVersion = $input->getArgument('version');

        if ($phpVersion) {
            $this->rebuildService->init($phpVersion, $io);
        }else{
            $io->error("PHP version not specified!!");
        }

        return 0;
    }
}
