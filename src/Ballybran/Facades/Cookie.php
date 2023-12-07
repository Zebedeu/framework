<?php

namespace Ballybran\Facades;

use Ballybran\Kernel\Facade;

class Cookie extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Ballybran\Http\Cookie::class;
    }
}