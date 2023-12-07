<?php

namespace Ballybran\Console;

use Ballybran\Kernel\Application;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Command extends SymfonyCommand
{
    /**
     * @var Application Application
     */
    protected $knut7;

    public function __construct(Application $app)
    {
        $this->knut7 = $app;

        parent::__construct();
    }

}
