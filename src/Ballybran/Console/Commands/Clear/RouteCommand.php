<?php

namespace Ballybran\Console\Commands\Clear;

use Ballybran\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RouteCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('clear:route')
            ->setDescription('Clear the application routes cache files.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cacheFile = cache_path('routes.php');
        if (file_exists($cacheFile) && unlink($cacheFile)) {
            $output->writeln('<info>+Success!</info> Routes cache file has been deleted.');
            return 0;
        }

        $output->writeln('<question>+Info!</question> There is no route cache file.');
        return 1;
    }
}
