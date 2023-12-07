<?php

namespace Ballybran\Providers;

use Ballybran\Kernel\ServiceProvider;

class Route extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     * @throws
     */
    public function register()
    {
        $this->app->singleton('route', \Ballybran\Router\Route::class);
    }
}
