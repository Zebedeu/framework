<?php

namespace Ballybran\Providers;

use Ballybran\Kernel\ServiceProvider;

class Session extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     * @throws
     */
    public function register()
    {
        $this->app->singleton(\Ballybran\Http\Session::class, \Ballybran\Http\Session::class);
    }
}
