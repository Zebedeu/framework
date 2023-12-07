<?php

namespace Ballybran\Providers;

use Ballybran\Kernel\ServiceProvider;
use Illuminate\Events\Dispatcher;
use Illuminate\Contracts\Queue\Factory as QueueFactoryContract;
use Ballybran\Event\Event as NurEvent;

class Event extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('events', function ($app) {
            return (new Dispatcher($app))->setQueueResolver(function () use ($app) {
                return $app->make(QueueFactoryContract::class);
            });
        });

        // Register Event-Listener Component of Knut7
        $this->app->singleton(NurEvent::class, NurEvent::class);
    }
}
