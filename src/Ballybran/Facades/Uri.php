<?php

namespace Ballybran\Facades;

use Ballybran\Kernel\Facade;

class Uri extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'uri';
    }
}