<?php

namespace Ballybran\Providers;

use Ballybran\Kernel\ServiceProvider;
use Ballybran\Http\Request as BaseRequest;
use Ballybran\Http\Validation;

class Request extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     * @throws
     */
    public function register()
    {
        // Request
        $this->app->singleton(BaseRequest::class, BaseRequest::class);

        // Validation
        $this->app->singleton(Validation::class, Validation::class);
    }
}
