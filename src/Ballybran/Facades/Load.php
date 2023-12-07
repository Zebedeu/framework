<?php

namespace Ballybran\Facades;

use Ballybran\Kernel\Facade;

class Load extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'load';
    }
}