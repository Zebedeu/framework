<?php

namespace Ballybran\Providers;

use Ballybran\Kernel\ServiceProvider;

class Uri extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     * @throws
     */
    public function register()
    {
        $this->app->singleton('uri', \Ballybran\Uri\Uri::class);
    }
}
