<?php

namespace Ballybran\Providers;

use Ballybran\Kernel\ServiceProvider;

class Pdox extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     * @throws
     */
    public function register()
    {
        $this->app->singleton('sql', \Ballybran\Database\Pdox::class);
    }
}
