<?php

namespace Ballybran\Console\Commands\Database;

use Ballybran\Console\Command;
use Ballybran\Database\Model;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SeedCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('db:seed')
            ->addOption('--class', '-c', InputOption::VALUE_OPTIONAL,
                'The class name of the root seeder. (Default: DatabaseSeeder)')
            ->addOption('--force', '-f', InputOption::VALUE_OPTIONAL,
                'Force to re-create database file.')
            ->setDescription('Seed the database with records.')
            ->setHelp("Seed the database with records.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $className = $input->hasParameterOption('--class')
            ? $input->getOption('class')
            : 'DatabaseSeeder';

        $this->executeSeeder($className);

        $output->writeln('<info>+Success!</info> Database seeding completed successfully.');
        return 0;
    }

    /**
     * @param string $seeder
     *
     * @return void
     * @throws
     */
    private function executeSeeder(string $seeder)
    {
        $seeder = $this->knut7->make($seeder, ['container' => $this->knut7]);
        Model::unguarded(function () use ($seeder) {
            $seeder->__invoke();
        });
    }
}
