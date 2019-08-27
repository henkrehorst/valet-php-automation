<?php

namespace App\Command;

use App\Service\SetupService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SetupInitialDataCommand extends Command
{
    private $setupService;

    public function __construct(SetupService $setupService)
    {
        $this->setupService = $setupService;
        parent::__construct();
    }

    protected static $defaultName = 'setup:initial-data';

    protected function configure()
    {
        $this->setDescription('Setup initial data for the php update cron');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->setupService->setup($io);
    }
}
