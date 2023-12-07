<?php

namespace Ballybran\Console\Commands\App;

use Ballybran\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:status')
            ->setDescription("The current state of the application.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!file_exists(storage_path('app.down'))) {
            $output->writeln("Knut7 Application's running.");
        } else {
            $output->writeln("Knut7 Application's in maintenance mode.");
        }

        return 0;
    }
}
