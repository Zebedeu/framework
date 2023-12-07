<?php

namespace Ballybran\Facades;

use Ballybran\Kernel\Facade;

class Session extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Ballybran\Http\Session::class;
    }
}