<?php

namespace Ballybran\Console\Commands\Migrations;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DownCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('down')
            ->addArgument('version', InputArgument::REQUIRED, 'The version number for the migration')
            ->setDescription('Revert a specific migration')
            ->setHelp(<<<EOT
The <info>down</info> command reverts a specific migration

<info>migration:down 20111018185412</info>

EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->bootstrap($input, $output);

        $migrations = $this->getMigrations();
        $versions = $this->getAdapter()->fetchAll();

        $version = $input->getArgument('version');

        if (!in_array($version, $versions)) {
            $output->writeLn('<error>-Error!</error> "' . $version . '" migration status already inactive.');
            return 1;
        }

        if (!isset($migrations[$version])) {
            $output->writeLn('<error>-Error!</error> "' . $version . '" migration not found. Please check migration ID.');
            return 1;
        }

        $container = $this->getContainer();
        $container['phpmig.migrator']->down($migrations[$version]);

        return 0;
    }
}
