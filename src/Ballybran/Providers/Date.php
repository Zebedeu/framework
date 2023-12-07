<?php

namespace Ballybran\Providers;

use Ballybran\Kernel\ServiceProvider;

class Date extends ServiceProvider
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
        $this->app->singleton('date', \Illuminate\Support\Carbon::class);
    }
}
