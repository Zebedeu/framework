<?php

namespace Ballybran\Providers;

use Ballybran\Kernel\ServiceProvider;

class Cookie extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     * @throws
     */
    public function register()
    {
        $this->app->singleton(\Ballybran\Http\Cookie::class, \Ballybran\Http\Cookie::class);
    }
}
