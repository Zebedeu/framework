<?php

namespace Ballybran\Console\Commands\Make;

use Ballybran\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EventCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('make:event')
            ->addArgument('name', InputArgument::REQUIRED, 'The name for the event.')
            ->addOption('--force', '-f', InputOption::VALUE_OPTIONAL, 'Force to re-create event.')
            ->setDescription('Create a new event.')
            ->setHelp("This command makes you to create event...");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $file = app_path('Events/' . $name . '.php');

        if (!file_exists($file)) {
            $this->createNewFile($file, $name);
            $output->writeln('<info>+Success!</info> "' . $name . '" event created.');
            return 0;
        }

        if ($input->hasParameterOption('--force') !== false) {
            unlink($file);
            $this->createNewFile($file, $name);
            $output->writeln('<info>+Success!</info> "' . $name . '" event re-created.');
            return 0;
        }

        $output->writeln('<error>-Error!</error> Event already exists! (' . $name . ')');
        return 1;
    }

    private function createNewFile(string $file, string $name)
    {
        $className = ucfirst($name);
        $contents = <<<PHP
<?php

namespace App\Events;

use Ballybran\Event\EventInterface;

class $className implements EventInterface
{
    /**
     * This method will be triggered
     * when you called it through event() method.
     *
     * @return mixed
     */
    public function handle()
    {
        return true;
    }
}

PHP;
        if (false === file_put_contents($file, $contents)) {
            throw new \RuntimeException(sprintf('The file "%s" could not be written to', $file));
        }
    }
}
