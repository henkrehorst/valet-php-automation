<?php

namespace App\Command;

use App\Service\UpdateService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CronPhpUpdateCommand extends Command
{
    private $updateService;

    protected static $defaultName = 'cron:php-update';

    public function __construct(UpdateService $updateService)
    {
        $this->updateService = $updateService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Check for php updates and if there are updates available, it starts the update process');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        //init update service class
        $this->updateService->init($io);
    }
}
