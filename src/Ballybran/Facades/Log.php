<?php

namespace Ballybran\Facades;

use Ballybran\Kernel\Facade;

class Log extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'log';
    }
}