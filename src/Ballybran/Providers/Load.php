<?php

namespace Ballybran\Providers;

use Ballybran\Kernel\ServiceProvider;

class Load extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     * @throws
     */
    public function register()
    {
        $this->app->singleton('load', \Ballybran\Load\Load::class);
    }
}
